<!-- Account Validated Email Content -->
@component('mail::message')

    # Hello Sweep Cleaning Service Team <br> 
    # Concern from {{$details['name']}}, <br>
    # {{ $details['email'] }} <br>
    # {{ $details['message'] }}<br>

@endcomponent
