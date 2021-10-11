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
    <button class="btn btn-primary" onclick="location.href='sweep-cleaning-service.herokuapp.com/verify/{{ $user_id }}'">Verify Email Address</button>
  </div>
  <p> Regards,</p>
  <p> Sweep Cleaning Service Team </p>
  <br><br>
  <p> If you're having trouble clicking the "Verify Email Address" button, click the link  https://sweep-cleaning-service.herokuapp.com/verify/{{ $user_id }}
</p> 
</body>

</html>