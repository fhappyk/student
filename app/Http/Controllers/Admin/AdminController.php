<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NewUserMail;
use App\Mail\TestConfigEmail;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Models\AllField;
use App\Models\Invitation;
use App\Models\Speciality;
use App\Models\StudentInfo;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\DataTables\UsersDataTable;
use App\Models\StudentCustomField;
use Illuminate\Support\Facades\DB;
use App\Imports\StudentsJsonImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\DataTables\ActiveUsersDataTable;
use Illuminate\Support\Facades\Response;
use App\DataTables\PendingUsersDataTable;
use App\DataTables\TrashedUsersDataTable;
use Illuminate\Support\Facades\Validator;
use App\DataTables\InActiveUsersDataTable;
use App\DataTables\InviteListingDataTable;
use QCod\Settings\Setting\Setting;

class AdminController extends Controller
{
   /* public function __construct()
    {
       exec('php artisan queue:work > /dev/null 2>&1 &');
    }*/

    public function runQueue()
    {
//        exec('php artisan queue:work > /dev/null 2>&1 &');
//        Run the queue:work and show the output in the logger for  debugging
//        exec('php artisan queue:work > storage/logs/queue.log 2>&1 &');
        Artisan::call('queue:work', []);
    }

    public function dashboard()
    {
        $totalUser = User::count();
        $activeUser = User::where('status', 'active')->count();
        $pendingUser = User::where('status', 'pending')->count();

        return view('admin.index', compact('totalUser', 'activeUser', 'pendingUser'));
    }

    public function allStudent(UsersDataTable $dataTable)
    {
        $jobs_in_queue = DB::table('jobs')->count();
        return $dataTable->render('admin.allStudent', compact('jobs_in_queue'));
    }

    public function loginStudent($id)
    {
        $user = User::findOrFail($id);
        auth()->login($user);
        return redirect()->route('edit.profile');
    }



    public function pendingStudent(PendingUsersDataTable $dataTable)
    {
        return $dataTable->render('admin.pendingStudent');
    }


    public function activeStudent(ActiveUsersDataTable $dataTable)
    {
        return $dataTable->render('admin.activeStudent');
    }

    public function inactiveStudent(InActiveUsersDataTable $dataTable)
    {
        return $dataTable->render('admin.inactiveStudent');
    }


    public function createStudent(){
//        $data['specialityAreas'] = Speciality::parents()->with('children')->get();
        $data['specialityAreas'] = Speciality::parents()->get();
        $data['specialities'] = Speciality::childrens()->get();
//        dd($data['specialityAreas']);
        return view('admin.createStudent', $data);
    }


    public function storeStudent(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country' => 'required',
            'uuid' => 'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }



        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'user_name' => $request->email,
                'email' => $request->email,
                'status' => $request->status,
                'uuid' => $request->uuid,
                'password' => Hash::make($request->password),
            ]);

            $imageName = '';
            if ($request->hasFile('image')) {
                $randomNo = Str::random(8);
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '.' . $randomNo . '.' . $extension;
                $image->move('uploads', $imageName);
            }

            $student = StudentInfo::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'professional_email' => $request->professional_email,
                'phone' => $request->phone,
                'professional_phone' => $request->professional_phone,
                'department' => $request->department,
                'speciality_area' => $request->speciality_area,
                'speciality' => $request->speciality,
                'region' => $request->region,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'lattitude' => $request->lattitude,
                'longitude' => $request->longitude,
                'image' => $imageName,
                'registration_date' => $request->registration_date,
                'office_name' => $request->office_name,
            ]);

            if ($request->has('fields')) {
                foreach ($request->fields as $field) {
                    StudentCustomField::create([
                        'user_id' => $user->id,
                        'label' => $field['label'],
                        'value' => $field['value'],
                    ]);
                }
            }

            if ($request->hasFile('image')) {
                try {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;

                    // Ensure the uploads directory exists
                    if (!file_exists(public_path('uploads'))) {
                        mkdir(public_path('uploads'), 0777, true);
                    } else {
                        // change the permissions
                        chmod(public_path('uploads'), 0777);
                    }

                    // Move the uploaded file
                    $file->move(public_path('uploads/'), $filename);
                    $image = 'public/uploads/' . $filename;

                    // Save the image path to the student object
                    $student->image = $image;

                    // Save the student object (assuming $student is an Eloquent model)
                    $student->save();

                } catch (FileException $e) {
//                    print_r($e->getMessage());
//                    dd($e);
                    // Handle file upload error
//                    return back()->with('error', 'File upload error: ' . $e->getMessage());
                } catch (\Exception $e) {
//                    print_r($e->getMessage());
//                    dd($e);
                    // Handle other exceptions
//                    return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
                }
            }



            $data = [
                'email' => $request->email,
                'title' => 'Registration Mail',
                'password' => $request->password,
                'route' => route('login'),
            ];

            try{
                // Fetch the email template from the database
                $email_template = EmailTemplate::where('for', 'create')->latest()->first();
                $body = $email_template->body;

                // Merge user data with extra fields
                $arrayOfUserAttributes = $user->load('studentinfo')->toArray();
                if (is_array($arrayOfUserAttributes['studentinfo'])) {
                    $arrayOfUserAttributes = array_merge($arrayOfUserAttributes, $arrayOfUserAttributes['studentinfo']);
                }
                unset($arrayOfUserAttributes['studentinfo']);

                $extraFields = [
                    'app.name' => config('app.name'),
                    'login_url' => $data['route'],
                ];
                $arrayOfUserAttributes = array_merge($arrayOfUserAttributes, $extraFields);

                // Replace placeholders in the body
                $email_template->body = replacePlaceholders($body, $arrayOfUserAttributes);

                // Convert email template to array
                $email_template_array = $email_template->toArray();
                $email_template_array['login_url'] = $data['route'];

//                Mail::send('mail.newUser', ['data' => $data], function ($message) use ($data) {
//                    $message->to($data['email'])->subject($data['title']);
//                    logger()->info('Email Sent to ',  [$data['email']]);
//                });
                Mail::to($user->email)->send(new NewUserMail([
                    'email_template' => $email_template,
                    'login_url' => $data['route'],
                    'email_template_array' => $email_template_array,
                ]));
            } catch (\Exception $e) {
                logger()->error($e);
                return redirect()->back()->with('error', "Email Configuration Error");

            }

        });

        return redirect()->route('admin.student')->with('success', 'New Student Added');


    }



    public function updateStudent(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'lattitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'uuid' => 'required',
            'password' => 'sometimes|nullable|confirmed',
        ]);

//        dd($request->all());

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->uuid = $request->uuid;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $studentInfo = StudentInfo::where('user_id', $user->id)->first();

        if ($studentInfo) {
            $studentInfo->user_id = $user->id;
            $studentInfo->title = $request->title;
            $studentInfo->phone = $request->phone;
            $studentInfo->country = $request->country;
            $studentInfo->city = $request->city;
            $studentInfo->address = $request->address;
            $studentInfo->lattitude = $request->lattitude;
            $studentInfo->longitude = $request->longitude;


            $studentInfo->professional_email  = $request->professional_email;
            $studentInfo->professional_phone  = $request->professional_phone;
            $studentInfo->department  = $request->department;
            $studentInfo->speciality_area  = $request->speciality_area;
            $studentInfo->speciality  = $request->speciality;
            $studentInfo->region  = $request->region;
            $studentInfo->registration_date  = $request->registration_date;
            $studentInfo->office_name  = $request->office_name;


            if ($request->hasFile('image')) {
                $randomNo = Str::random(8);
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '.' . $randomNo . '.' . $extension;
                $image->move('uploads', $imageName);
                $studentInfo->image = $imageName;
            }
            $studentInfo->save();
        }else{
            $studentInfo = new StudentInfo();

            $studentInfo->user_id = $user->id;
            $studentInfo->title = $request->title ?: '';
            $studentInfo->phone = $request->phone ?: '';
            $studentInfo->country = $request->country ?: '';
            $studentInfo->city = $request->city ?: '';
            $studentInfo->address = $request->address ?: '';
            $studentInfo->lattitude = $request->lattitude ?: '';
            $studentInfo->longitude = $request->longitude ?: '';

            $studentInfo->professional_email = $request->professional_email ?: '';
            $studentInfo->professional_phone = $request->professional_phone ?: '';
            $studentInfo->department = $request->department ?: '';
            $studentInfo->speciality_area = $request->speciality_area ?: '';
            $studentInfo->speciality = $request->speciality ?: '';
            $studentInfo->region = $request->region ?: '';
            $studentInfo->registration_date = $request->registration_date ?: '';
            $studentInfo->office_name = $request->office_name ?: '';

            if ($request->hasFile('image')) {
                $randomNo = Str::random(8);
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '.' . $randomNo . '.' . $extension;
                $image->move('uploads', $imageName);
                $studentInfo->image = $imageName;
            }


            $studentInfo->save();

        }

        if ($request->has('fields')) {
            foreach ($request->fields as $field) {
                StudentCustomField::create([
                    'user_id' => $user->id,
                    'label' => $field['label'],
                    'value' => $field['value'],
                ]);
            }
        }

        if ($request->has('extrafield')) {
            foreach ($request->extrafield as $label => $value) {
                StudentCustomField::updateOrCreate(
                    ['user_id' => $user->id, 'label' => $label],
                    ['value' => $value]
                );
            }
        }





        return redirect()->route('admin.student')->with('success', 'Student updated successfully');



    }






    public function viewStudent($id){
        $data = User::find($id);

        return view('admin.viewStudent', compact('data'));
    }



    public function editStudent($id){
        $data = User::with('studentinfo', 'extrafield')->find($id);

        $specialityAreas = Speciality::parents()->get();
        $specialities = Speciality::childrens()->get();

        return view('admin.editStudent', compact('data', 'specialityAreas', 'specialities'));
    }


    public function deleteStudent($id){
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('Student Deleted Successfully');

    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.trashed')->with('success', 'User restored successfully');
    }


    public function trashedUsers(TrashedUsersDataTable $dataTable)
    {
        return $dataTable->render('admin.trashedStudent');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.trashed')->with('success', 'User permanently deleted.');
    }





    public function changeStatus($id, $status){
        $user = User::findOrFail($id);
        $user->status = $status;
        $user->save();
        return redirect()->back()->with('success', 'Status Update');
    }



    public function import(Request $request)
    {

//        $file = $request->file('file');
//        dd($file->getClientMimeType(), $file->getMimeType());
//
//        dd($request->all());

        $validate = Validator::make($request->all(), [
//            'file' => 'required|mimes:xlsx,xls,csv',
            'file' => 'required|mimetypes:text/csv,text/plain,application/csv,application/excel,application/vnd.ms-excel,application/vnd.msexcel,text/comma-separated-values,text/x-comma-separated-values,text/tab-separated-values',
        ]);

        if ($validate->fails()) {
            Session::flash('error', 'Please upload XLSX, XLS or CSV file.');
            return redirect()->back()->withErrors($validate)->withInput();
        }


        try {
//            dd('here');
//            dd($request->file('file')->getPathname());
//            Artisan::call('queue:work', [
//                '--stop-when-empty' => false,
//            ]);
//            Excel::import(new StudentsImport, $request->file('file'));
            // This throws an error: Path cannot be empty

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                if ($file->isValid()) {
                    try {
                        Excel::import(new StudentsImport, $file);
                        return back()->with('success', 'File imported successfully.')
                            ->with('import_log', session('import_log'));
                    } catch (\Exception $e) {
                        return back()->withErrors(['file' => 'Error during import: ' . $e->getMessage()]);
                    }
                } else {
                    return back()->withErrors(['file' => 'Uploaded file is not valid.']);
                }
            } else {
                return back()->withErrors(['file' => 'No file was uploaded.']);
            }

            exec('php artisan queue:work > /dev/null 2>&1 &');

            return redirect()->back()->with('success', 'Data Imported Successfully!');
        } catch (\Exception $e) {
            Log::error('Error importing JSON: ', ['exception' => $e->getMessage()]);
            Log::error('Error importing JSON: ', ['exception' => $e]);
            return redirect()->back()->with('error', 'Error importing students: ');
        }
    }


    public function importJson(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'json_file' => 'required|file|mimes:json',
        ]);

        if ($validate->fails()) {
            Session::flash('error', 'Please upload Json file.');
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
//            Artisan::call('queue:work', [
//                '--stop-when-empty' => false,
//            ]);
//            Artisan::call('queue:work');
            $file = $request->file('json_file');
            $importer = new StudentsJsonImport();
            $importer->import($file->getRealPath());
            exec('php artisan queue:work > /dev/null 2>&1 &');

            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            Log::error('Error importing JSON: ', ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error importing students: ');
        }
    }



    public function exportJson()
    {
    $students = User::with(['studentinfo' => function ($query) {
        $query->select('user_id', 'title', 'phone', 'professional_phone', 'professional_email', 'country', 'city', 'address', 'lattitude', 'longitude', 'department', 'speciality', 'speciality_area', 'registration_date');
    }])->where('role', 'student')->get(['id','uuid', 'name', 'user_name', 'email', 'status']);

    $transformedData = $students->map(function ($student) {
        return [
            'uuid' => $student->uuid,
            'title' => optional($student->studentinfo)->title,
            'name' => $student->name,
            'user_name' => $student->user_name,
            'email' => $student->email,
            'status' => $student->status,
            'phone' => optional($student->studentinfo)->phone,
            'professional_phone' => optional($student->studentinfo)->professional_phone,
            'professional_email' => optional($student->studentinfo)->professional_email,
            'country' => optional($student->studentinfo)->country,
            'city' => optional($student->studentinfo)->city,
            'address' => optional($student->studentinfo)->address,
            'lattitude' => optional($student->studentinfo)->lattitude,
            'longitude' => optional($student->studentinfo)->longitude,
            'department' => optional($student->studentinfo)->department,
            'speciality_area' => optional($student->studentinfo)->speciality_area,
            'speciality' => optional($student->studentinfo)->speciality,
            'registration_date' => optional($student->studentinfo)->registration_date,
        ];
    });
        $jsonData = $transformedData->toJson(JSON_PRETTY_PRINT);

        // Create a file and save it to the storage
        $fileName = 'students_' . date('Y_m_d_H_i_s') . '.json';
        Storage::disk('local')->put($fileName, $jsonData);

        return Response::download(storage_path("app/{$fileName}"));
    }


    public function inviteStudent(InviteListingDataTable $dataTable){

        return $dataTable->render('admin.inviteStudent');
    }


    public function createInvite(){
        return view('admin.createInvite');
    }

    public function sendInvite(Request $request){

        $id = Str::uuid();

        $hasUser = User::where('email', $request->email)->first();



        $hasInvite = Invitation::where('uuid', $request->uuid)->where('email', $request->email)->first();
        if(!$hasInvite && !$hasUser){

            Invitation::create([
                'name' => $request->name,
                'email' => $request->email,
                'uuid' => $request->uuid,
            ]);

            $registration = route('register', [
                'uuid' => $request->uuid,
                'email' => $request->email,
            ]);


            $data['email'] = $request->email;
            $data['title'] = 'registration Invitation';

            $data['body'] = $registration;

            $replace_able_fields = [
                'app.name' => config('app.name'),
                'register_url' => $registration,
                'name' => $request->name,
                'email' => $request->email,
                'uuid' => $request->uuid,
            ];

            try{

                // Fetch the email template from the database
                $email_template = EmailTemplate::where('for', 'invite')->latest()->first();
                $body = $email_template->body;

                // Replace placeholders in the body
                $email_template->body = replacePlaceholders($body, $replace_able_fields);

                // Convert email template to array
                $email_template_array = $email_template->toArray();
                $email_template_array['register_url'] = $registration;

                exec('php artisan queue:work > /dev/null 2>&1 &');

                Mail::to($data['email'])->send(new InvitationMail([
                    'email_template' => $email_template,
                    'register_url' => $registration,
                    'email_template_array' => $email_template_array,
                ]));
            } catch (\Exception $e) {
                return redirect()->back()->with('error',"Email Configuration Error");
            }

            return redirect()->back()->with('success', 'Invitation Send');

        }


        return redirect()->back()->with('error', 'Invitation Already Exist');


    }


    public function deleteInvite($id){
        $invite = Invitation::find($id);
        $invite->delete();

        return redirect()->back()->with('success', 'Invitation Delete Successfully');

    }



    public function fieldStudent(){

        $fields = AllField::all();
        return view('admin.setting.fieldSetting', compact('fields'));
    }

    public function updateStatus(Request $request, $id)
    {
        $field = AllField::find($id);
        $field->status = $request->status;
        $field->save();

        return response()->json(['success' => true]);
    }



    public function setting(){
        return view('admin.setting.setting');
    }

    public function emailSettings(){
        return view('admin.setting.email');
    }

    public function twilioSettings(){
        return view('admin.setting.twilio');
    }

    public function emailTemplates(){
        $templates = EmailTemplate::all();
        return view('admin.setting.emailTemplates', compact('templates'));
    }

    public function editEmailTemplates(Request $request, $id){
        $template = EmailTemplate::find($id);
        return response()->json(['status' => 'success', 'result' => $template]);
    }

    public function updateEmailTemplates(Request $request){
        $request->validate([
            'et_id' => 'required',
            'et_name' => 'required',
            'et_subject' => 'required',
            'et_body' => 'required',
            'et_for' => 'nullable',
        ]);

        $data = [
            'name' => $request->et_name,
            'subject' => $request->et_subject,
            'body' => $request->et_body,
            'for' => $request->et_for,
        ];

        $emailTemplate = EmailTemplate::find($request->et_id);

        $emailTemplate->update($data);

        if (request()?->ajax()) {
            return response()->json(['status' => 'success', 'data' => $emailTemplate]);
        }

        return redirect()->back()->with('success', 'Email Template Updated');
    }

    public function emailTemplatesPost(Request $request){
        $request->validate([
            'et_name' => 'required',
            'et_subject' => 'required',
            'et_body' => 'required',
            'et_for' => 'nullable',
        ]);

        $data = [
            'name' => $request->et_name,
            'subject' => $request->et_subject,
            'body' => $request->et_body,
            'for' => $request->et_for,
        ];

        $emailTemplate = EmailTemplate::create($data);

        if (request()?->ajax()) {
            return response()->json(['status' => 'success', 'data' => $emailTemplate]);
        }

        return redirect()->back()->with('success', 'Email Template Created');
    }

    public function saveSettings(Request $request){
        $data = $request->all();
        unset($data['_token']);

        foreach ($data as $key => $value) {
            settings()->set($key, $value);
        }

        $smtp_host = $request->smtp_host;
        $smtp_port = $request->smtp_port;
        $smtp_uname = $request->smtp_uname;
        $smtp_pwd = $request->smtp_pwd;
        $smtp_issecure = $request->smtp_issecure;
        $smtp_emailfrom = $request->smtp_emailfrom;
        $smtp_replyto = $request->smtp_replyto;

        if ($smtp_host && $smtp_port && $smtp_uname && $smtp_pwd && $smtp_issecure && $smtp_emailfrom && $smtp_replyto)
        {
            setEnv('MAIL_HOST', $smtp_host);
            setEnv('MAIL_PORT', $smtp_port);
            setEnv('MAIL_USERNAME', $smtp_uname);
            setEnv('MAIL_PASSWORD', $smtp_pwd);
            setEnv('MAIL_ENCRYPTION', $smtp_issecure);
            setEnv('MAIL_FROM_ADDRESS', $smtp_emailfrom);
//            setEnv('MAIL_FROM_NAME', config('app.name'));
            setEnv('MAIL_REPLY_TO', $smtp_replyto);
        }

        $twilio_sid = $request->twilio_sid;
        $twilio_token = $request->twilio_token;
        $twilio_number = $request->twilio_number;

        if ($twilio_sid && $twilio_token && $twilio_number)
        {
            setEnv('TWILIO_SID', $twilio_sid);
            setEnv('TWILIO_AUTH_TOKEN', $twilio_token);
            setEnv('TWILIO_PHONE_NUMBER', $twilio_number);
        }

        return redirect()->back()->with('success', 'Settings Saved');
    }

    public function testEmailSettings(Request $request){

        $request->validate([
            'testemailto' => 'required|email',
        ]);

        try{

            $emailConfigs = emailConfigs();

            $data = [
                'email' => $request->testemailto,
                'subject' => 'Test Email Configuration',
                'from' => $emailConfigs['from_address'],
                'from_name' => $emailConfigs['from_name'],
                'reply_to' => $emailConfigs['reply_to'],
                'body' => 'This is a test email to check the email settings',
            ];
            Mail::to($data['email'])->send(new TestConfigEmail($data));
        } catch (\Exception $e) {
            logger()->error($e);
            return redirect()->back()->with('error', 'Email Configuration Error');
        }

        return redirect()->back()->with('success', 'Email Sent Successfully');
    }

    public function dropdownStudent(){
        $specialityArea = Speciality::where('type', 'speciality area')->get();
        $speciality = Speciality::where('type', 'speciality')->get();
        return view('admin.dropdown', get_defined_vars());

    }

    public function saveSpecialityArea(Request $request)
    {
        Speciality::create([
            'title' => $request->speciality_area,
            'type' => 'speciality area',
        ]);
        return redirect()->back();
    }


    public function saveSpeciality(Request $request)
    {
        Speciality::create([
            'title' => $request->speciality,
            'type' => 'speciality',
        ]);
        return redirect()->back();
    }
    public function deleteDropdown($id)
    {
        $Speciality = Speciality::find($id);
        $Speciality->delete();
        return redirect()->back();

    }


}
