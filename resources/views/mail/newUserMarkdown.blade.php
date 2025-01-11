<x-mail::message>

# {{ $data['email_template_array']['subject'] }}

{!! $data['email_template_array']['body'] !!}

<x-mail::button :url="$data['email_template_array']['login_url']">
    Get Started
</x-mail::button>

</x-mail::message>
