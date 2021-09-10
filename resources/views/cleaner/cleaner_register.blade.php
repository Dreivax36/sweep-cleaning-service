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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customer_login.css')}}">
</head>
<body class="reg_customer_body">
    <div class="register_con">
            <h4 class="register_label">
                Create an Account
            </h4>
            <form action="{{ route('cleaner.cleaner_save') }}" method="post" enctype="multipart/form-data">
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
                <div class="upload_con">
                    <div class="form-group">
                        <label class="upload_label">
                            Profile Picture
                        </label>
                        <input type="file" name="profile_picture" class="form-control upload_file">
                        <span class="text-danger">
                            @error('profile_picture'){{ $message }} @enderror
                        </span>
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
                    <div class="form-group">
                        <label class="upload_label">
                            Requirement
                        </label>
                        <input type="file" name="requirement" class="form-control upload_file">
                        <span class="text-danger">
                            @error('requirement'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="description" placeholder="Description" value="{{ old('description') }}">
                    <span class="text-danger">
                        @error('description'){{ $message }} @enderror
                    </span>
                </div>
                <button type="submit" class="register_cleaner_btn btn-primary">
                    Sign Up
                </button>
                <br>
                <a class="login_link_btn" href="{{ route('cleaner.cleaner_login') }}"> 
                    I already have an account, Sign In
                </a>
                </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>
</html>