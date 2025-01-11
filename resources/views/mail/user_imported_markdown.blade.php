<x-mail::message>

# {{ $data['email_template_array']['subject'] }}

{!! $data['email_template_array']['body'] !!}

<x-mail::button :url="$data['email_template_array']['resetUrl']">
    Reset Password
</x-mail::button>

</x-mail::message>
