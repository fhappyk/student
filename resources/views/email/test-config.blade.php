<x-mail::message>
# {{ $data['subject'] }}

{!! $data['body'] !!}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
