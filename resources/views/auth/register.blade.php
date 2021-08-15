<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
        <title> SWEEP </title>
</head>
<body class="loginbody">
    <div class="logincontainer">
        <div class="row" style="margin-top:45px">
            <h4 class="signin">Register</h4>
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
                    <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                </div>
                <button type="submit" class="registerbutton">Sign Up</button>
                <br>
                <a class="linklogin" href="{{ route('auth.login') }}"> I already have an account, sign in</a>
        </div>
    </div>
</body>
</html>