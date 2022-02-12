<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Cleaner Register 
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cleaner_reg.css')}}">
</head>
<body class="reg_cleaner_body">
    <div class="register_con_cleaner">
        <h4 class="register_label">
            Create an Account
        </h4>
        <!-- Form for Cleaner Registration Account -->
        <form action="{{ route('cleaner.cleaner_save_step2') }}" method="post" enctype="multipart/form-data">
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
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5>
                            Birthday
                        </h5>
                        <input type="date" class="input" name="birthday" value="{{ old('birthday') }}">
                        <span class="text-danger">
                            @error('birthday'){{ $message }} @enderror
                        </span>
                    </div>
                </div>                    
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <div>
                        <h5>
                            Address
                        </h5>
                        <input type="text" class="input" name="address" value="{{ old('address') }}">
                        <span class="text-danger">
                            @error('address'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="id-cont">
                    <h5>
                        Acceptable Valid ID's:
                    </h5>
                    <p>
                        UMID, Driver'sLicense, Philhealth Card, SSS ID, Passport, School ID, PhilSys ID
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
            <button type="submit" class="register_cleaner_btn">
                Next
            </button>
        </form>
        <br>
        <a class="login_link_btn" href="{{ route('cleaner.cleaner_login') }}"> 
            I already have an account, Sign In
        </a>
    </div>
    <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>
</html>