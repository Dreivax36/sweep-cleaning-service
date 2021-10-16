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
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
</head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light sweep-nav shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brandname" href="{{ url('/') }}">
                    SWEEP
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Center Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <a id="home" class="nav-link" href="/" role="button">Home</a>
                        <a id="services" class="nav-link" href="services" role="button">Services</a>
                        <a id="jobs" class="nav-link" href="jobs" role="button">Jobs</a>
                        <a id="about_us" class="nav-link" href="about_us" role="button">About Us</a>
                        <a id="contact_us" class="nav-link active" href="contact_us" role="button">Contact Us</a>
                    </ul>

                    <ul class="navbar-nav d-flex">
                        <!-- Authentication Links -->
                        @if (Route::has('customer.customer_login'))
                        <a class="btn login_btn" href="{{ route('customer.customer_login') }}">{{ __('Login') }}</a>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="banner-container">
        <div class="row">
            <div class="col-md-5 get-touch">
                <h1 class="title">Get in Touch.</h1>
                <div class="text">
                    We are committed in hearing your thoughts.
                    If you need help or have any comments, questions or suggestions.
                    Or might be interested to join our team.
                    Send us a message or contact us directly.
                </div>
                <div class="sweep">
                    <b class="sweepinc">SWEEP Inc.</b>
                    <br>
                    <div class="address">
                        B4, L2, Narra St. Palestina, Pili, Cam. Sur
                        4418, Philippines
                    </div>
                </div>
                <div class="support">
                    <b class="sweepinc"> SUPPORT </b>
                    <br>
                    <div class="address">
                        email.support@gmail.com
                        <br>
                        +63 9000000000
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card message">
                    <form action="{{ route('customer.customer_save') }}" method="post" enctype="multipart/form-data">
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
                        <div class="user-details">
                            <div class="input-div">
                                <div>
                                    <h5>Full Name</h5>
                                    <input type="text" class="form-control input" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}">
                                    <span class="text-danger">
                                        @error('full_name'){{ $message }} @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="input-div">
                                <div>
                                    <h5>Email</h5>
                                    <input type="text" class="form-control input" name="email" placeholder="Email" value="{{ old('email') }}">
                                    <span class="text-danger">
                                        @error('email'){{ $message }} @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="input-div">
                                <div>
                                    <h5>Message</h5>
                                    <textarea type="text" rows="8" cols="50" class="form-control contact_fields" name="message" placeholder="Message" value="{{ old('message') }}"></textarea>
                                    <span class="text-danger">
                                        @error('message'){{ $message }} @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="download">
        <div class="row3">
            <div class="dcont">
                <h2 class="dtitle">Download our App</h2>
                <p class="d-text">Download the app and get your homes clean with just a click of a button. Now available on the Google Play Store.</p>
                <a class="btn btn-primary down_btn" href="{{ 'about_us' }}">{{ __('Download Now') }}</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </div>
</body>