<x-mail::message>

# {{ $data['email_template_array']['subject'] }}

{!! $data['email_template_array']['body'] !!}

Note: In case you can't see the otp code, here it is: <strong>{{ $data['email_template_array']['otp'] }}</strong>

</x-mail::message>
