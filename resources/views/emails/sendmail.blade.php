<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sweep Cleaning Service</title>
</head>

<body>
  <h3> {{ $details['title'] }} </h3>
  <h2> Hello! </h2>
  <p> Please click the button below to verify your email address. Thank you!</p>
  <div class="d-flex justify-content-center">
  <a class="btn btn-primary" role="button" target="_blank" href="https://sweep-cleaning-service.herokuapp.com/verify/{{ $details['user_id'] }}/"></a>
  </div>
  <p> Regards,</p>
  <p> Sweep Cleaning Service Team </p>
  <br><br>
  <p> If you're having trouble clicking the "Verify Email Address" button, click the link  <a target="_blank" href="https://sweep-cleaning-service.herokuapp.com/verify/{{ $details['user_id'] }}/"></a> 
</p> 
</body>

</html>