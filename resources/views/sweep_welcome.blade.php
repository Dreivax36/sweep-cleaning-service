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
    <nav class="navbar navbar-expand-lg sticky-top navbar-light sweep-nav shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brandname" href="{{ url('/customer/customer_dashboard') }}">
                SWEEP
            </a>
            <!-- Notification -->
            <ul class="navbar-nav mx-auto">
                <a id="home" class="nav-link active" href="/" role="button">Home</a>
                <a id="services" class="nav-link" href="services" role="button">Services</a>
                <a id="jobs" class="nav-link" href="jobs" role="button">Jobs</a>
                <a id="about_us" class="nav-link" href="about_us" role="button">About Us</a>
                <a id="contact_us" class="nav-link" href="contact_us" role="button">Contact Us</a>
            </ul>
            <ul class="navbar-nav login-web d-flex">
                <!-- Authentication Links -->
                @if (Route::has('customer.customer_login'))
                <a class="btn login_btn-top" href="{{ route('customer.customer_login') }}">{{ __('Login') }}</a>
                @endif
            </ul>
            <!-- Mobile -->
            <ul class="mobile-nav sticky-bottom">
                <a class="nav-button active" href="{{ url('/') }}">
                    <i class="fas fa-home fas-active"></i>
                    <h6>Home</h6>
                </a>
                <a class="nav-button" href="{{ url('/cleaning') }}">
                    <i class="fas fa-hand-sparkles"></i>
                    <h6>Services</h6>
                </a>
            </ul>
        </div>
    </nav>

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
        <section>
            <div class="slider">
                <div id="bannerSlides" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="banner" style="background-image: url('/images/home/homeheader.jpg')">
                                <div class="carousel-container">
                                    <div class="caption">
                                        <h1 class="text black">Your BEST Companion towards Cleanliness is here!</h1>
                                        <p class="text">Making your comfort zones squeaky clean one step at a time.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="banner" style="background-image:  url('/images/home/headhome.jpg')">
                                <div class="carousel-container">
                                    <div class="caption">
                                        <h1 class="text black">Upholstery Cleaning</h1>
                                        <p class="text">Concentrating on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="banner" style="background-image: url('/images/home/deep_cleaning.jpg')">
                                <div class="carousel-container">
                                    <div class="caption">
                                        <h1 class="text black">Deep Cleaning</h1>
                                        <p class="text"> A deeper dive into a clean environment, this service includes deep cleaning, bedroom organization, simple upholstery cleaning and simple disinfection.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="recommendation">
            <div class="recom_title">
                <h3 class="title1 text">Our Recommendations</h3>
            </div>
            <div class="slider1">
                <div class="slider-cont">
                    <div class="recom-service">
                        <div class="card reco-service1">
                            <div class="services">
                                <h5 class="for-you2">Good for a Weekly Service</h5>
                                <h2 class="title2">Light Home Cleaning</h2>
                                <p class="for-you-text">
                                    This service will ensure that your home is clear of dust, filth, and
                                    debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="recom-service">
                        <div class="card reco-service">
                            <div class="services">
                                <h5 class="for-you2">Recommended for Monthly</h5>
                                <h2 class="title2">Deep Home Cleaning</h2>
                                <p class="for-you-text">A deeper dive into maintaining a clean environment. This focuses all attention to every nook and crany. Makes sure that your space is clean and safe.</p>
                            </div>
                        </div>
                    </div>
                    <div class="recom-service">
                        <div class="card reco-service1">
                            <div class="services">
                                <h5 class="for-you2">Good for Daily/Weekly Service</h5>
                                <h2 class="title2">Maid for a Day Service</h2>
                                <p class="for-you-text">
                                    This service will provide a worry-free day in the house by having a maid take care of the essential household chores.
                                    Four to eight hours a day with one to two maids.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="recommendation">
            <div class="recom_title">
                <h3 class="title1 text">Other Services</h3>
            </div>
            <div class="slider2">
                    <a href="{{ url('/cleaning') }}" class="recom">
                        <div class="card other">
                            <div class="services">
                                <h2 class="title3">Home Cleaning Services</h2>
                                <p class="for-you-text">
                                    Various Cleaning Services tailored for your needs. Your place will be clean and tidy and you Stress-Free.
                                </p>
                            </div>
                        </div>
                    </a>
            </div>
        </div>



        <!-- Mobile -->
        <div class="mobile-spacer">
        </div>
    </div>

</body>