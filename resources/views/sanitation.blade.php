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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/services2.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-light sweep-nav shadow-sm">
        <div>
            <a type="button" class="navbar-toggler" href="{{ url('/') }}">
                <i class="fas fa-arrow-left"></i>
            </a>
            <a class="navbar-brandname" href="{{ url('/') }}">
                SWEEP
            </a>
            <!-- Notification -->
            <ul class="navbar-nav ml-auto">
                <a id="home" class="nav-link active" href="/" role="button">Home</a>
                <a id="services" class="nav-link" href="services" role="button">Services</a>
                <a id="jobs" class="nav-link" href="jobs" role="button">Jobs</a>
                <a id="about_us" class="nav-link" href="about_us" role="button">About Us</a>
                <a id="contact_us" class="nav-link" href="contact_us" role="button">Contact Us</a>
            </ul>
            <!-- Mobile -->
            <ul class="mobile-nav sticky-bottom">
                <p class="login-text">Cheers to a cleaner lifestyle!</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <ul class="navbar-nav d-flex">
                            <!-- Authentication Links -->
                            @if (Route::has('customer.customer_login'))
                            <a class="btn login_btn" href="{{ route('customer.customer_login') }}">{{ __('Login') }}</a>
                            @endif
                        </ul>

                    </div>
                    <div class="col-md-6">
                        <ul class="navbar-nav d-flex">
                            <!-- Authentication Links -->
                            @if (Route::has('customer.customer_login'))
                            <a class="btn reg_btn" href="{{ route('customer.customer_register') }}">{{ __('Register') }}</a>
                            @endif
                        </ul>
                    </div>
                </div>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="col-md-6">
            <div class="title">
                <h1> Services </h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card ">
                <div class="card-body">
                    <h3 class="card-title">Sanitation and Germ Proofing</h3>
                    <p class="card-text">This service will emphasize thorough sanitation, which will include disinfectant spray and antimicrobial fogging.</p>
                    <!-- <a class="btn btn-primary" href="/customer/customer_login">Learn More</a> -->
                </div>
            </div>
        </div>
        <!-- Mobile -->
        <div class="mobile-spacer">
        </div>
    </div>
</body>