<?php

use Carbon\Carbon;
use App\Models\Time_entry;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Employee Time In/Out
    </title>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Scripts -->
    

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customer_login.css')}}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript"  id="gwt-pst" src="{{ asset('js/time.js')}}"></script>

    <script>
      function refreshTime(){
        var refresh = 1000;
        mytime = setTimeout('display_dateTime()', refresh);
      }

      function display_dateTime(){
        var date = new Date();
        document.getElementById("time").innerHTML = date.toLocaleTimeString();
        refreshTime();
      }
  </script> 

</head>

<body class="reg_customer_body flex-row align-items-center" onload="display_dateTime();">
    <div class="register_con">
        <h4 class="signin_label">
            Employee Time In/Out
        </h4>

            <div class="local_time_con">
                <div id="pst-container">
                    <div class="local_time_title">
                        Philippine Standard Time
                    </div>
                    <h1 id="time"></h1>
                    <h6><?php echo \Carbon\Carbon::now()->format('l, F d, Y'); ?></h6>
                </div>
            </div>
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
                    @if(Session::get('fail-timeout'))
                    <script>
                        swal({
                            title: "Please Time in first!",
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
                    <input type="text" class="input" name="employee_code" value="{{ old('employee_code') }}" required>
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
            <br>
        </form>
    </div>
    <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>

</html>