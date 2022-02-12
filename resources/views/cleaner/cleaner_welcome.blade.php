<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="{{ asset('js/sweep.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.gonoogleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>

    <title>
        Sweep Cleaners Account
    </title>
    <link href="{{ asset('css/cleaner_welcome.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard">
        <div class="row">
            <div class="col-md-6 cleaners">
                <div class="image">
                    <img src="/images/home/home_header.png" class="img-fluid">
                </div>
                <div class="text">
                    <h1>
                        Sweep Cleaners Account
                    </h1>
                    <p>
                        Join us in our mission on making homes clean one step at a time
                    </p>
                    <a class="btn btn-primary signup_btn" href="/customer/customer_register">{{ __('Sign Up') }}</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="register_con">
                    <h4 class="signin_label">
                        Sign In
                    </h4>
                    <!-- Form for login -->
                    <form action="{{ route('cleaner.cleaner_check') }}" method="post">
                        @if(Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                        @endif

                        @csrf
                        <div class="input-div">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5>
                                    Email
                                </h5>
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
                                <h5>
                                    Password
                                </h5>
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
                        <a class="register_link_btn" href="/cleaner/cleaner_register">
                            I don't have an Account, Create New
                        </a>
                    </form>
                </div>
                <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
            </div>
        </div>
    </div>

    <!-- Mobile Version -->
    <div class="mobile-bg">
        <div class="row justify-content-center">
            <div class="recommendation">
                <div class="slider">
                    <div id="bannerSlides" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="carousel-container1">
                                    <div class="image">
                                        <img src="/images/home/home_header.png" class="img-fluid img">
                                    </div>
                                    <div class="text">
                                        <h1>
                                            Sweep Cleaner Accounts
                                        </h1>
                                        <p>
                                            Join us in our mission on making homes clean one step at a time
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer" class="get-started">
            <div class="signup">
                New to Sweep?
                <a class="btn btn-primary signup_btn1" style="height: 35px; border-radius: 15px;" href="/cleaner/cleaner_register">{{ __('Sign Up') }}</a>
            </div>
            <div class="login">
                <a class="btn btn-link signup_btn1" href="/cleaner/cleaner_login">{{ __('Have an account? Login.') }}</a>
            </div>
        </div>
    </div>
</body>