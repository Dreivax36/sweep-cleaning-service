<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Event;
    use App\Models\Notification;
    use Carbon\Carbon;
    use App\Models\Service_review;
    use App\Models\Time_entry;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Employee Login 
    </title>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customer_login.css')}}">
</head>
<body class="reg_customer_body flex-row align-items-center">
    <div class="register_con">
        <h4 class="signin_label">
            Employee Time In / Time Out
        </h4>
        <form action="{{ route('timeIn') }}" method="post" id="myform">
          @if(Session::get('success-timein'))
            <script>
              swal({
              title: "Time In Successful!",
              icon: "success",
              button: "Close",
              });
            </script> 
          @endif
          @if(Session::get('success-timeout'))
            <script>
              swal({
              title: "Time Out Successful!",
              icon: "success",
              button: "Close",
              });
            </script>
          @endif
          @if(Session::get('fail'))
            <script>
              swal({
                title: "Something went wrong, try again!",
                icon: "error",
                button: "Close",
              });
          </script>
          @endif

          @csrf
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5>Employee Code</h5>
                        <input type="text" class="input" name="email" value="{{ old('email') }}">
                        <span class="text-danger">
                        @error('email'){{ $message }} @enderror
                        </span>
                    </div>
                </div>

        <div class="buttons">

          <button type="submit" class="btn btn-block btn-primary timein_btn" name="timeIn" value="{{now()->toDateTimeString()}}">
            TIME IN
          </button>
          <button type="submit" class="btn btn-block btn-danger timeout_btn timein_btn" name="timeOut" value="{{now()->toDateTimeString()}}">
            TIME OUT
          </button>
        </div>
        </form>
    </div>
    <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>
</html>