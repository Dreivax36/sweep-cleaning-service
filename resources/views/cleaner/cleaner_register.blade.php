<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Cleaner Register 
    </title>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
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
                        <input type="text" class="form-control reg_fields" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}">
                        <span class="text-danger">
                            @error('full_name'){{ $message }} @enderror
                        </span>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control reg_fields" name="age" placeholder="Age" value="{{ old('age') }}">
                    <span class="text-danger">
                        @error('age'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                        <input type="text" class="form-control reg_fields" name="address" placeholder="Address" value="{{ old('address') }}">
                        <span class="text-danger">
                            @error('address'){{ $message }} @enderror
                        </span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    <span class="text-danger">
                        @error('email'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number') }}">
                    <span class="text-danger">
                        @error('contact_number'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control login_fields @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                    <span class="text-danger">
                        @error('password'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control login_fields @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Confirm Password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="upload_label">
                        Profile Picture:
                    </label>
                    <input type="file" name="profile_picture" class="form-control">
                    <span class="text-danger">
                        @error('profile_picture'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label class="upload_label">
                        Valid ID:
                    </label>
                    <input type="file" name="valid_id" class="form-control">
                    <span class="text-danger">
                        @error('valid_id'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="description" placeholder="Description" value="{{ old('description') }}">
                    <span class="text-danger">
                        @error('description'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <label class="upload_label">
                        Requirement:
                    </label>
                    <input type="file" name="requirement" class="form-control">
                    <span class="text-danger">
                        @error('requirement'){{ $message }} @enderror
                    </span>
                </div>
                <button type="submit" class="register_btn">
                    Sign Up
                </button>
                <br>
                <a class="login_link_btn" href="{{ route('cleaner.cleaner_login') }}"> 
                    I already have an account, Sign In
                </a>
        </div>
    </div>
</body>
</html>