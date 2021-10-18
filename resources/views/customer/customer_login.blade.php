<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Customer Login 
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
<body class="reg_customer_body">
<div class="register_con">
            <h4 class="signin_label">
                Sign In
            </h4>
            <form action="{{ route('customer.customer_check') }}" method="post">
                @if(Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif
                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @csrf
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5>Email</h5>
                        <input type="text" class="input" name="email" value="{{ old('email') }}">
                        <span class="text-danger">
                        @error('email'){{ $message }} @enderror
                    </span>
                    </div>
                </div>
                <div class="input-div">
                    <div class="icon">
                    <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5>Password</h5>
                        <input type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <span class="text-danger">
                        @error('password'){{ $message }} @enderror
                    </span>
                    </div>
                </div> 
                <button type="submit" class="login_customer_btn">
                    Login
                </button>
                <br>
                <a class="register_link_btn" href="/customer/customer_register"> 
                    I don't have an Account, Create New
                </a>
            </form>
    </div>
<script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>
</html>