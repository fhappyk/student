<?php

namespace App\Imports;

use App\Jobs\SendUserImportedEmail;
use App\Models\User;
use App\Mail\UserImported;
use App\Models\StudentInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Password;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
//        Artisan::call('queue:work', [
//            '--stop-when-empty' => true,
//        ]);
//        Artisan::call('queue:work', []);
        exec('php artisan queue:work > /dev/null 2>&1 &');

    }

    public function model(array $row)
    {
        Log::info('Importing row: ', $row);
//        $temp_log_array[] = 'Importing process started for row';
//        $temp_log_array[] = $row;
//        session()->put('import_log', $temp_log_array);

        if (isset($row['name'], $row['email'], $row['uuid'], $row['country'], $row['department'])) {
            if (User::where('email', $row['email'])->orWhere('uuid', $row['uuid'])->exists()) {
                Log::info('User already exists, skipping row: ', $row);
//                $temp_log_array[] = 'User already exists, skipping row' . $row;
//                session()->put('import_log', $temp_log_array);
                return null;
            }

            try {
                DB::beginTransaction();

                $user = User::create([
                    'name' => $row['name'],
                    'user_name' => $row['email'],
                    'email' => $row['email'],
                    'status' => $row['status'] ?? 'pending',
                    'role' => 'student',
                    'password' => Hash::make(substr(Str::uuid(), 0, 8)),
                    'uuid' => $row['uuid'],
                    'created_at' => now(),
                    'updated_at' => now(),
//                    'registration_date' => Carbon::make($row['registration_date']),
                ]);

                Log::info('User record imported successfully: ', $row);
//                $temp_log_array[] = 'User record imported successfully' . $row;
//                session()->put('import_log', $temp_log_array);

                $token = Password::broker()->createToken($user);
                $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));

//                Mail::to($user->email)->send(new UserImported($user, $resetUrl));
//                Artisan::call('queue:work', [
//                    '--stop-when-empty' => true,
//                ]);
//                SendUserImportedEmail::dispatch($user, $resetUrl);
//                Log::info('Email sending to user: ', $row);
//                $temp_log_array[] = 'Email sent to user' . $row;
//                session()->put('import_log', $temp_log_array);

                $this->importStudentInfo($user, $row);

                DB::commit();

                SendUserImportedEmail::dispatch($user, $resetUrl);
                Log::info('Email sending to user: ', $row);

                return $user;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Some Fields Are Missing');
                Log::error($e);

//                $temp_log_array[] = 'Some Fields Are Missing';
//                $temp_log_array[] = $e;
//                session()->put('import_log', $temp_log_array);

                if (isset($user)) {
                    $user->delete();
                }

                throw $e;
            }
        } else {
            Log::error('Required Fields Are Missing in the File');
//            $temp_log_array[] = 'Required Fields Are Missing in the File';
//            session()->put('import_log', $temp_log_array);
            return null;
        }
    }

    private function importStudentInfo($user, $row)
    {
        $optionalKeys = ['title', 'phone', 'professional_phone', 'professional_email', 'country', 'city', 'address', 'lattitude', 'longitude', 'department', 'speciality_area',  'speciality', 'registration_date', 'office_name'];
        $studentInfoData = [];
        foreach ($optionalKeys as $key) {
            if (isset($row[$key])) {
                if ($key === 'registration_date') {
                    $studentInfoData[$key] = Carbon::make($row[$key]);
                } else {
                    $studentInfoData[$key] = $row[$key];
                }
            }
        }

        if (!empty($studentInfoData)) {
            $studentInfoData['user_id'] = $user->id;
            StudentInfo::updateOrCreate(['user_id' => $user->id], $studentInfoData);
            Log::info('Student info imported successfully for user: ', $row);
//            $temp_log_array[] = 'Student info imported successfully for user' . $row;
//            session()->put('import_log', $temp_log_array);
        }
    }
}
