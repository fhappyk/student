<?php

namespace App\Services;

use App\Models\Otp;
use Carbon\Carbon;
use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(config('services.twilio.sid'), config('services.twilio.auth_token'));
    }

    final public function sendOTP(string $to, string $message): void
    {
        $this->twilio->messages->create($to, [
            'from' => config('services.twilio.phone_number'),
            'body' => $message
        ]);
    }

    final public function sendOTPDefault(String $phone_number): Otp
    {
        $otp_code = random_int(100000, 999999);
        $message = "Use {$otp_code} as your verification code for ". config('app.name') .". This code will expire in 5 minutes.";

        $this->sendOTP($phone_number, $message);

        return Otp::create([
            'phone_number' => $phone_number,
            'otp_code' => $otp_code,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);
    }

    final public function verifyOTP(String $phone_number, String $otp_code): bool
    {
        $otp = Otp::where('phone_number', $phone_number)
            ->where('otp_code', $otp_code)
            ->where('expires_at', '>=', Carbon::now())
            ->where('expires_at', '<=', Carbon::now()->addMinutes(5))
            ->first();

        if ($otp) {
            $otp->delete();
            return true;
        }

        return false;
    }

}
