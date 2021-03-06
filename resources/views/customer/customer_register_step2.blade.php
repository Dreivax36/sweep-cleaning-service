<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Customer Register 
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customer_reg.css')}}">
</head>
<body class="reg_customer_body">
    <div class="register_con">
        <h4 class="register_label">
            Create an Account
        </h4>
        <!-- Form for customer registration -->
        <form action="{{ route('customer.customer_save_step2') }}" method="post" enctype="multipart/form-data">
            @if(Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>  
            @endif

            @if(Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif
                
            @csrf
            <input type="hidden" name="user_id" value="{{$user_id}}">
            <div class="user-details">
                <div class="id-cont">
                    <h5>
                        Acceptable Valid ID's:
                    </h5>
                    <p>
                        UMID, Driver'sLicense, Philhealth Card, SSS ID, Passport, PhilSys ID
                    </p>
                </div>
                <div class="form-group">
                    <label class="upload_label">
                        Valid ID
                    </label>
                    <input type="file" name="valid_id" class="form-control upload_file">
                    <span class="text-danger">
                        @error('valid_id'){{ $message }} @enderror
                    </span>
                </div> 
            </div>
            <button type="submit" class="register_customer_btn">
                Sign Up
            </button>
        </form>
        <br>
        <a class="login_link_btn"  href="/customer/customer_login"> 
            I already have an account, Sign In
        </a>
    </div>
    <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>
</html>