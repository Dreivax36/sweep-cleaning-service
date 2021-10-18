@component('mail::message')
# Hello {{$details['name']}},
{{ $details['title'] }} <br>
{{ $details['body'] }}<br>
You can now avail our services. <br>
Thank you.<br>
Regards,<br>
Sweep Cleaning Service Team 

@endcomponent
