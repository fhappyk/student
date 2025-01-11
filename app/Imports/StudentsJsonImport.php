<?php

namespace App\Imports;

use App\Jobs\SendUserImportedEmail;
use App\Models\User;
use App\Mail\UserImported;
use App\Models\StudentInfo;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class StudentsJsonImport
{
    public function __construct()
    {
//        Artisan::call('queue:work', [
//            '--stop-when-empty' => true,
//        ]);
//        Artisan::call('queue:work', []);
        exec('php artisan queue:work > /dev/null 2>&1 &');

    }

    public function import($filePath)
    {
        $json = File::get($filePath);
        $data = json_decode($json, true);

        DB::transaction(function () use ($data) {
            foreach ($data as $row) {
                Log::info('Importing row: ', $row);

                if ($this->hasRequiredKeys($row)) {
                if (User::where('email', $row['email'])->orWhere('uuid', $row['uuid'])->exists()) {
                // if (User::where('email', $row['email'])->exists()) {
                        Log::info('Email already exists, skipping row: ', $row);
                        continue;
                    }

                    $user = User::updateOrCreate(
                        ['email' => $row['email']],
                        [
                            'name' => $row['name'],
                            'user_name' => $row['user_name'],
                            'status' => $row['status'],
                            'role' => 'student',
                            'password' => Hash::make(substr(Str::uuid(), 0, 8)),
                            'uuid' => $row['uuid'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    Log::info('User record imported successfully: ', $row);

                    if ($this->hasStudentInfoKeys($row)) {
                        StudentInfo::updateOrCreate(
                            ['user_id' => $user->id],
                            [
                                'title' => $row['title'] ?? null,
                                'phone' => $row['phone'] ?? null,
                                'professional_phone' => $row['professional_phone'] ?? null,
                                'professional_email' => $row['professional_email'] ?? null,
                                'country' => $row['country'] ?? null,
                                'city' => $row['city'] ?? null,
                                'address' => $row['address'] ?? null,
                                'lattitude' => $row['lattitude'] ?? null,
                                'longitude' => $row['longitude'] ?? null,
                                'department' => $row['department'] ?? null,
                                'speciality_area' => $row['speciality_area'] ?? null,
                                'speciality' => $row['speciality'] ?? null,
                                'registration_date' => $row['registration_date'] ?? null,
                                'office_name' => $row['office_name'] ?? null,
                            ]
                        );

                        Log::info('Student info imported successfully for user: ', $row);
                    }

                    $token = Password::broker()->createToken($user);
                    $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));

//                    Mail::to($user->email)->send(new UserImported($user, $resetUrl));
                    SendUserImportedEmail::dispatch($user, $resetUrl);
                    Log::info('Email sent to user: ', $row);
                } else {
                    if (isset($user)) {
                        $user->delete();
                    }
                    if (isset($studentInfo)) {
                        $studentInfo->delete();
                    }
                    Log::error('Some Fields Are Missing');
                    throw new \Exception('Some Fields Are Missing');
                }
            }
        });
    }

    private function hasRequiredKeys($row)
    {
        $requiredKeys = ['uuid', 'first_name', 'last_name', 'email', 'status'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $row)) {
                return false;
            }
        }
        return true;
    }

    private function hasStudentInfoKeys($row)
    {
        $optionalKeys = ['phone', 'professional_phone', 'professional_email', 'country', 'city', 'address', 'latitude', 'longitude', 'department', 'speciality', 'speciality_area', 'registration_date', 'title', 'office_name'];
        foreach ($optionalKeys as $key) {
            if (array_key_exists($key, $row)) {
                return true;
            }
        }
        return false;
    }
}
