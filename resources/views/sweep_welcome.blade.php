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
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>


    <title>
        Welcome Page
    </title>
    <link href="{{ asset('css/style_welcome.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
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
                        <a id="home" class="nav-link active" href="/" role="button">Home</a>
                        <a id="services" class="nav-link" href="services" role="button">Services</a>
                        <a id="jobs" class="nav-link" href="jobs" role="button">Jobs</a>
                        <a id="about_us" class="nav-link" href="about_us" role="button">About Us</a>
                        <a id="contact_us" class="nav-link" href="contact_us" role="button">Contact Us</a>
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
        <div class="banner">
            <div class="text">
                <h1>The Road to Cleanliness has never been easier.</h1>
                <p>Making your comfort zones squeaky clean one step at a time.</p>
                <a class="btn btn-primary signup_btn" href="/customer/customer_register">{{ __('Sign Up') }}</a>

            </div>
            <div class="image">
                <img src="images/home/home_header.png" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="three_reason">
        <div class="container">
            <div class="row gx-5">
                <div class="text col-sm-4">
                    <i class="fas fa-money-bill-wave fa-2x"></i>
                    <h4 class="title">Affordable</h4>
                    <p>
                        Sweep focuses on you. With various services offered, there is one that is perfect for you.
                    </p>
                </div>
                <div class="text col-sm-4">
                    <i class="fas fa-hand-sparkles fa-2x"></i>
                    <h4 class="title">Quality Assured</h4>
                    <p class="desc">
                        All plans have there respective points checklist provided for you. This make sure that an availed service is of good quality.
                    </p>
                </div>
                <div class="text col-sm-4">
                    <i class="fas fa-business-time fa-2x"></i>
                    <h4 class="title">Convenient</h4>
                    <p class="desc">
                        We lift your burdens by providing an extra set of hands enabling you to carry on with your lives with ease.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- has some bugs -->
    <div class="more-info">
        <div class="row1">
            <div class="foryou">
                <h5 class="for-you">For You</h5>
                <h2 class="title1">We're all about<br>cleanliness and<br>convenience.</h2>
                <p class="for-you-text">Save yourself the hassle by booking cleaning services. Our goal is to to make sure everyone would live and work in a clean, safe, and enjoyable environment.</p>
                <a class="btn btn-primary learn_btn" href="{{ 'about_us' }}">{{ __('Learn More') }}</a>
            </div>
            <div class="col-7">
                <img src="images/home/for-you.jpg" class="img-fluid">
            </div>
        </div>
        <div class="row2">
            <div class="col-6">
                <img src="images/home/services.jpg" class="img-fluid">
            </div>
            <div class="services">
                <h5 class="for-you2">Services</h5>
                <h2 class="title2">Longing for <br>Cleanliness? Easy.</h2>
                <p class="for-you-text">Sweep provides quality cleaning and sanitation services ready for you to avail.</p>
                <a class="btn btn-primary learn_srvbtn" href="{{ 'about_us' }}">{{ __('Learn More') }}</a>
            </div>
        </div>
    </div>
    <!-- emd has some bugs -->

    <div class="faqs_con">
        <h2 class="faqs_title">
            Frequently Asked Questions
        </h2>
        <div class="qna">
            <div class="qna_block">
                <div class="question">
                    <h4 class="question_title">
                        How to book a cleaning service?
                    </h4>
                    <i class="fas fa-angle-down fa-2x"></i>
                </div>
                <div class="answer">
                    You have to login to your account, go to the services page, choose a cleaning service you want to book, indicate the date and time, and pay for your booking.
                </div>
            </div>

            <div class="qna_block">
                <div class="question">
                    <h4 class="question_title">
                        Can I cancel a booked service?
                    </h4>
                    <i class="fas fa-angle-down fa-2x"></i>
                </div>
                <div class="answer">
                    Yes, you can cancel a booked service any time before its scheduled date.
                </div>
            </div>
            <div class="qna_block">
                <div class="question">
                    <h4 class="question_title">
                        How long a cleaning service will last?
                    </h4>
                    <i class="fas fa-angle-down fa-2x"></i>
                </div>
                <div class="answer">
                    The cleaning process varies between the chosen service. Generally a service would last for 1-2 hours.
                </div>
            </div>
            <div class="qna_block">
                <div class="question">
                    <h4 class="question_title">
                        Is SWEEP safe?
                    </h4>
                    <i class="fas fa-angle-down fa-2x"></i>
                </div>
                <div class="answer">
                    WE make sure that both our customers and cleaners are safe before, during, and after the service.
                </div>
            </div>
            <div class="qna_block">
                <div class="question">
                    <h4 class="question_title">
                        How to pay a booked service?
                    </h4>
                    <i class="fas fa-angle-down fa-2x"></i>
                </div>
                <div class="answer">
                    Sweep offers online payments such as Paypal or Gcash
                </div>
            </div>
            <div class="qna_block">
                <div class="question">
                    <h4 class="question_title">
                        What are the cleaning services offered?
                    </h4>
                    <i class="fas fa-angle-down fa-2x"></i>
                </div>
                <div class="answer">
                    For details about the cleaning services, please refer to the cleaning services page.
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

    <div class="mobile-bg">
        <div class="row justify-content-center">
            <div class="recommendation">
                <div class="slider">
                    <div id="bannerSlides" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="carousel-container1">
                                    <div class="image">
                                        <img src="images/home/home_header.png" class="img-fluid img">
                                    </div>
                                    <div class="text">
                                        <h1>The Road to Cleanliness has never been easier.</h1>
                                        <p>Making your comfort zones squeaky clean one step at a time.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-container1">
                                    <div class="image">
                                        <img src="images/img1.png" class="img-fluid img1">
                                    </div>
                                    <div class="text">
                                        <h1>We're all about cleanliness and convenience.</h1>
                                        <p>Save yourself the hassle by booking cleaning services. Our goal is to to make sure everyone would live and work in a clean, safe, and enjoyable environment.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-container1">
                                    <div class="image">
                                        <img src="images/img2.png" class="img-fluid img">
                                    </div>
                                    <div class="text">
                                        <h1>Longing for Cleanliness? Easy.</h1>
                                        <p>Sweep provides quality cleaning and sanitation services ready for you to avail.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ol class="carousel-indicators indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer" class="get-started">
            <div class="signup">
                New to Sweep?
                <a class="btn btn-primary signup_btn1" style="height: 35px; border-radius: 15px;" href="/customer/customer_register">{{ __('Sign Up') }}</a>
            </div>
            <div class="login">
                <a class="btn btn-link signup_btn1" href="/customer/customer_login">{{ __('Have an account? Login.') }}</a>
            </div>
        </div>

    </div>

</body>