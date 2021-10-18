@component('mail::message')
# Hello {{$details['name']}},
{{ $details['title'] }} <br>
{{ $details['body'] }}<br>

Thank you.<br>
Regards,<br>
Sweep Cleaning Service Team 

@component('mail::subcopy')

You can now avail our services. 
<br> 
Here's the link of our website. <br>
    "<a target="_blank" href="https://sweep-cleaning-service.herokuapp.com">https://sweep-cleaning-service.herokuapp.com</a>"   
@endcomponent
@endcomponent
