@component('mail::message')

    # Hello {{$details['name']}},
    {{ $details['title'] }} 
    {{ $details['body'] }}

    You can now avail our services.
    Thank you.
    Regards,
    Sweep Cleaning Service Team 

@endcomponent
