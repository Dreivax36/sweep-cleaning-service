@component('mail::message')
# Hello {{$details['name']}},

Please click the button below to verify your email address.
@if ($details['user_type'] == 'Customer')                 
  @component('mail::button', ['url' => url('verify', $details['user_id'])])
  Verify Email Address
  @endcomponent
@else
  @component('mail::button', ['url' => url('verify_cleaner', $details['user_id'])])
  Verify Email Address
  @endcomponent
@endif 

Thank you.<br>
Regards,<br>
Sweep Cleaning Service Team 

@component('mail::subcopy')

If you're having trouble clicking the "Verify Email Address" button, click the link below.  
<br> 
    @if ($details['user_type'] == 'Customer')
      "<a target="_blank" href="https://sweep-cleaning-service.herokuapp.com/verify/{{ $details['user_id'] }}/">https://sweep-cleaning-service.herokuapp.com/verify/{{ $details['user_id'] }}</a>"   
    @else
      "<a target="_blank" href="https://sweep-cleaning-service.herokuapp.com/verify/{{ $details['user_id'] }}/">https://sweep-cleaning-service.herokuapp.com/verify/{{ $details['user_id'] }}</a>"
    @endif
@endcomponent
@endcomponent
