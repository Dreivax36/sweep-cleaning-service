<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Admin Login 
    </title>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
</head>
<body class="login_body">
    <div class="login_con">
        <div class="row">
            <h4 class="signin_label">
                Admin Area 🔐
            </h4>
            <form action="{{ route('auth.check') }}" method="post">
                @if(Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif

                @csrf
                <div class="form-group">
                    <input type="text" class="form-control login_fields" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    <span class="text-danger">
                        @error('email'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <div class="password_con">
                        <input type="password" class="form-control login_fields" name="password" id="password" placeholder="Password" />
                        <div class="eye_con">
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </div>
                    </div>
                    <span class="text-danger">
                        @error('password'){{ $message }} @enderror
                    </span>
                </div>
                <button type="submit" class="login_btn">
                    Login
                </button>
                <br>
        </div>
    </div>
    <!-- Toggle Password Visibility -->
    <script type="text/javascript">
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('bi-eye');
        });
    </script>
</body>
</html>