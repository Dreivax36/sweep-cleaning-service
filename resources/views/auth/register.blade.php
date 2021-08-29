<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Admin Register 
    </title>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
    <link rel="shortcut icon" href="#">
</head>
<body class="reg_body">
    <div class="register_con">
        <div class="row">
            <h4 class="register_label">
                Register
            </h4>
            <form action="{{ route('auth.save') }}" method="post">
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
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="name" placeholder="Full Name" value="{{ old('name') }}">
                    <span class="text-danger">
                        @error('name'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    <span class="text-danger">
                        @error('email'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control reg_fields" name="password" placeholder="Password">
                    <span class="text-danger">
                        @error('password'){{ $message }} @enderror
                    </span>
                </div>
                <button type="submit" class="register_btn">
                    Sign Up
                </button>
                <br>
                <a class="login_link_btn" href="{{ route('auth.login') }}"> 
                    I already have an account, sign in
                </a>
        </div>
    </div>
</body>
</html>