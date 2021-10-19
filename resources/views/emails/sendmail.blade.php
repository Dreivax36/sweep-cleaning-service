<!-- Email address verify Content-->
@component('mail::message')

  # Hello {{$details['name']}},

  Please click the button below to verify your email address.
  <!-- Check the user type to redirect to respective login page -->
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

@endcomponent
