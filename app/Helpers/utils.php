<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('replacePlaceholders')) {
    function replacePlaceholders($template, $data) {
        foreach ($data as $key => $value) {
            // Replace placeholders in the format {key} with the corresponding value
            $template = str_replace("{{$key}}", $value, $template);
        }
        return $template;
    }
}

if (!function_exists('emailConfigs')) {
    function emailConfigs(): bool|array
    {
        try {
            // Retrieve email settings from the database
            $emailHost = settings('smtp_host');
            $emailPort = (int) settings('smtp_port');
            $emailUsername = settings('smtp_uname');
            $emailPassword = settings('smtp_pwd');
            $emailEncryption = settings('smtp_issecure');
            $emailFromAddress = settings('smtp_emailfrom');
            $emailFromName = config('app.name');
            $emailReplyTo = settings('smtp_replyto');

            // Dynamically set the mail configuration
            Config::set('mail.mailers.smtp.host', $emailHost);
            Config::set('mail.mailers.smtp.port', $emailPort);
            Config::set('mail.mailers.smtp.username', $emailUsername);
            Config::set('mail.mailers.smtp.password', $emailPassword);
            Config::set('mail.mailers.smtp.encryption', $emailEncryption);
            Config::set('mail.from.address', $emailFromAddress);
            Config::set('mail.from.name', $emailFromName);

            return [
                'host' => $emailHost,
                'port' => $emailPort,
                'username' => $emailUsername,
                'password' => $emailPassword,
                'encryption' => $emailEncryption,
                'from_address' => $emailFromAddress,
                'from_name' => $emailFromName,
                'reply_to' => $emailReplyTo,
            ];
        } catch (\Exception $e) {
            // Log the error
            logger()?->error('Error populating email configurations: ' . $e->getMessage());
            return false;
        }
    }

    if (!function_exists('setEnv')) {
        function setEnv($key, $value)
        {
            $envFilePath = app()->environmentFilePath();

            // Get the current .env file content
            $envContent = file_get_contents($envFilePath);

            // Check if the key already exists
            $keyExists = strpos($envContent, "{$key}=") !== false;

            if ($keyExists) {
                // Replace the key value in the .env file
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                // If the key does not exist, append it to the file
                $envContent .= "{$key}={$value}\n";
            }

            // Write the updated content back to the .env file
            file_put_contents($envFilePath, $envContent);
        }
    }

}
