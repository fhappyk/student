<?php

namespace App\Http\Controllers\Auth;

use App\Mail\OtpMail;
use App\Models\EmailTemplate;
use App\Models\Otp;
use App\Models\User;
use App\Models\Invitation;
use App\Models\StudentInfo;
use App\Services\TwilioService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }


    public function viewLogin(){
        if(!auth()->user()){

            return view('login');
        }else{
            return redirect()->back();
        }

    }
    public function viewRegister($uuid, $email)
    {
        $invitation = Invitation::where('email', $email)->where('uuid', $uuid)->first();

        if (!is_null($invitation)) {
            if (!auth()->check()) {
                return view('register', compact('uuid', 'email'));
            } else {
                return redirect()->back();
            }
        }

        return redirect()->route('home');
    }

    public function register(Request $request) {
        $validate = Validator::make($request->all(), [
            'uuid' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $invite = Invitation::where('uuid', $request->uuid)->where('email', $request->email)->first();



        $user = User::create([
            'first_name' => $invite->first_name,
            'last_name' => $invite->last_name,
            'email' => $request->email,
            'uuid' => $request->uuid,
            'user_name' => $request->email,
            'password' => Hash::make($request->password),
        ]);




        Session::flash('success', 'Registered Successfully');


        return redirect()->route('account.verification',$user->id);

    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'otp_method' => 'required'
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $userCredentials = $request->only('email', 'password');



        $userData = User::where('email',$request->email)->first();

        // check if user and password is correct and then redirect to sms/email otp page
        if($userData && Hash::check($request->password, $userData->password)){
            $this->sendOtp($userData, $request->otp_method);
//            dd('OTP sent');
            return redirect()->route('account.verification',$userData->id);
        }

        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }



    public function sendOtp($user, $otp_method)
    {
        try {
            $otp = rand(100000,999999);

            if ($otp_method === 'sms') {
                $phone = $user->studentinfo->phone;
                $message = "Use {$otp} as your verification code for ". config('app.name') .". This code will expire in 5 minutes.";

                if (!$phone) {
                    return redirect()->back()->with('error', "Phone number not found to send OTP");
                }

                Otp::create([
                    'method' => 'sms',
                    'phone' => $phone,
                    'email' => $user->email,
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(5),
                ]);

                // send sms using twilio
                $this->twilio->sendOTP($phone, $message);
            } else {
                Otp::create([
                    'method' => 'email',
                    'email' => $user->email,
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(5),
                ]);

                $data['email'] = $user->email;
                $data['title'] = 'Mail Verification';
                $data['body'] = 'Your OTP is:- '.$otp;

                $replace_able_fields = [
                    'app.name' => config('app.name'),
                    'email' => $user->email,
                    'otp_code' => $otp,
                ];

                try{
                    // Fetch the email template from the database
                    $email_template = EmailTemplate::where('for', 'otp')->latest()->first();
                    $body = $email_template->body;

                    // Replace placeholders in the body
                    $email_template->body = replacePlaceholders($body, $replace_able_fields);

                    // Convert email template to array
                    $email_template_array = $email_template->toArray();
                    $email_template_array['otp'] = $otp;

                    /*exec('php artisan queue:work > /dev/null 2>&1 &');*/

                    Mail::to($data['email'])->send(new OtpMail([
                        'email_template' => $email_template,
                        'otp' => $otp,
                        'email_template_array' => $email_template_array,
                    ]));
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return redirect()->back()->with('error', "Email Configuration Error");
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', "Error sending OTP" . $e->getMessage());
        }
    }



    public function verification($id)
    {
        $user = User::where('id',$id)->first();
        if(!$user){
            return redirect()->back()->with('error', "User not found");
        }
        $email = $user->email;
        $otpData = Otp::where('email',$email)->latest()->first();
        if(!$otpData){
            return redirect()->back()->with('error', "OTP not found");
        }

        return view('verification',compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $otpData = Otp::where('otp',$request->otp)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
        }
        else{

            $currentTime = time();
            $time = $otpData->created_at;

            if($currentTime >= $time && $time >= $currentTime - (120+5)){
                User::where('email',$otpData->email)->update([
                    'is_verified' => 1
                ]);

                return response()->json(['success' => true,'msg'=> 'Logged in Successfully']);

            }
            else{
                return response()->json(['success' => true,'msg'=> 'Your OTP has been Expired']);
            }
        }
    }

    public function verifiedOtp(Request $request)
    {
//        dd($request->all());
        $user = User::where('email',$request->email)->first();
        $otpData = Otp::where('email',$request->email)->latest()->first();

        if(!$otpData){
//            return redirect()->back()->with('error', "OTP not found");
            return response()->json(['success' => false,'msg'=> 'OTP not found']);
        }

        if ($otpData->otp == $request->otp) {
            // check if otp is expired: 5 minutes
            if($otpData->expires_at >= now()){
                Auth::login($user);
                if ($user->role == 'admin') {
//                    return redirect()->route('admin.dashboard');
                    return response()->json([
                        'success' => true,
                        'msg'=> 'Logged in Successfully',
                        'redirect' => route('admin.dashboard')
                    ]);
                } else {
//                    return redirect()->route('edit.profile', $user->id);
                    return response()->json([
                        'success' => true,
                        'msg'=> 'Logged in Successfully',
                        'redirect' => route('edit.profile', $user->id)
                    ]);
                }
            }

//            return redirect()->back()->with('error', "Your OTP has been Expired");
            return response()->json(['success' => false,'msg'=> 'Your OTP has been Expired']);
        }

//        return redirect()->back()->with('error', "You entered wrong OTP");
        return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
    }

    public function resendOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = Otp::where('email',$request->email)->latest()->first();

        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'OTP not found']);
        }

        $this->sendOtp($user, $otpData->method);

        return response()->json(['success' => true,'msg'=> 'OTP sent successfully']);

    }





    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        Session::flash('success', 'You have been successfully Logout.');

        return redirect('/');
    }


    public function forgotPassword(){
        return view('forgotPassword');

    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }



    public function showResetForm(Request $request, $token = null)
    {
        return view('resetPassword')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }






}
