@component('mail::message')

  # Hello {{$details['name']}},

  Please click the button below to verify your email address.               
    @component('mail::button', ['url' => url('verify', $details['user_id'])])
      Verify Email Address
    @endcomponent

  Thank you.
  Regards,
  Sweep Cleaning Service Team 

@endcomponent
