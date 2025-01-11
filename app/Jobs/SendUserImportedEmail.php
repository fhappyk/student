<?php

namespace App\Jobs;

use App\Mail\TestConfigEmail;
use App\Mail\UserImported;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendUserImportedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $resetUrl;
    public $email_template;
    public $email_template_array;

    public function __construct($user, $resetUrl)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;

        // Fetch the email template from the database
        $this->email_template = EmailTemplate::where('for', 'import')->latest()->first();
        $body = $this->email_template->body;

        // Merge user data with extra fields
        $arrayOfUserAttributes = $this->user->load('studentinfo')->toArray();
        if (is_array($arrayOfUserAttributes['studentinfo'])) {
            $arrayOfUserAttributes = array_merge($arrayOfUserAttributes, $arrayOfUserAttributes['studentinfo']);
        }
        unset($arrayOfUserAttributes['studentinfo']);

        $extraFields = [
            'app.name' => config('app.name'),
            'resetUrl' => $this->resetUrl,
        ];
        $arrayOfUserAttributes = array_merge($arrayOfUserAttributes, $extraFields);

        // Replace placeholders in the body
        $this->email_template->body = replacePlaceholders($body, $arrayOfUserAttributes);

        // Convert email template to array
        $this->email_template_array = $this->email_template->toArray();
        $this->email_template_array['resetUrl'] = $this->resetUrl;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new UserImported([
            'email_template' => $this->email_template,
            'resetUrl' => $this->resetUrl,
            'email_template_array' => $this->email_template_array,
        ]));
    }
}

