@extends('head_extention_customer') 

@section('content')
    <title>
        Customer Dashboard Page
    </title>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-target="#carouselExampleCaptions" data-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-target="#carouselExampleCaptions" data-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-target="#carouselExampleCaptions" data-slide-to="2" aria-label="Slide 3"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="carousel-container">
                <h1>Deep Cleaning</h1>
                <p class="carousel-prg">
                    A deeper dive into a clean environment, this service includes deep cleaning, bedroom organization, simple upholstery cleaning and simple disinfection.
                </p>
                <a href="#" class="btn btn-lg btn-primary">
                    Book Now
                </a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="carousel-container">
                <h1>Upholstery Cleaning</h1>
                <p class="carousel-prg">
                    Concentrating on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance.
                </p>
                <a href="#" class="btn btn-lg btn-primary">
                    Book Now
                </a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="carousel-container">
                <h1>General Cleaning</h1>
                <p class="carousel-prg">
                Comprises of sweeping, vacuuming, light dusting and a simple disinfection. This service will ensure that your home is clear of dust, filth, and debris.
                </p>
                <a href="#" class="btn btn-lg btn-primary">
                    Book Now
                </a>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>

<div class="banner">
    <div class="book_container">
        <h1 class="no_active">
            Currently, You have no Active Bookings
        </h1>
        <p class="qoute">
            Making your comfort zones squeaky clean one step at a time.
        </p>
        <a class="btn btn-primary down_btn" href="{{ url('/customer/customer_services') }}">{{ __('Book Now') }}</a>
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
@endsection