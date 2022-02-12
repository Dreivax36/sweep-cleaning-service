@extends('/customer/customer-nav/head_extention_customer')

@section('content')
<title>
    Customer Dashboard Page
</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
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
                            <div class="carousel-container1">
                                <div class="caption">
                                    <h1 class="text-left black">
                                        Your BEST Companion towards Cleanliness is here!
                                    </h1>
                                    <p class="my-2 my-lg-4 text1">
                                        Now serving Naga City! The Heart of Bicol.
                                    </p>
                                    <p class="my-2 my-lg-4 text">
                                        Making your comfort zones squeaky clean one step at a time.
                                    </p>
                                </div>
                                <a href="{{ url('/customer/customer_services') }}" class="btn btn-lg btn-primary">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="banner" style="background-image:  url('/images/home/headhome.jpg')">
                            <div class="carousel-container">
                                <div class="caption">
                                    <h1 class="text-left black">
                                        Upholstery Cleaning
                                    </h1>
                                    <p class="my-3 my-lg-6 text">
                                        Concentrating on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance.
                                    </p>
                                    <a href="{{ url('/customer/customer_services') }}" class="btn btn-lg btn-primary">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="banner" style="background-image: url('/images/deep_cleaning.jpg')">
                            <div class="carousel-container">
                                <div class="caption">
                                    <h1 class="text-left black">
                                        Deep Cleaning
                                    </h1>
                                    <p class="my-4 my-lg-6 text"> 
                                        A deeper dive into a clean environment, this service includes deep cleaning, bedroom organization, simple upholstery cleaning and simple disinfection.
                                    </p>
                                    <a href="{{ url('/customer/customer_services') }}" class="btn btn-lg btn-primary">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#bannerSlides" role="button" data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sr-only">
                        Previous
                    </span>
                </a>
                <a class="carousel-control-next" href="#bannerSlides" role="button" data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                    <span class="sr-only">
                        Next
                    </span>
                </a>
            </div>
        </div>
    </section>
    <div class="recommendation">
        <div class="recom_title">
            <h5 class="for-you1">
                Services
            </h5>
            <h3 class="title1">
                Our Recommendations
            </h3>
        </div>
        <div class="slider">
            <div id="bannerSlides" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="recom-service">
                            <div class="row justify-content-center">
                                <div class="card reco-service1">
                                    <div class="services">
                                        <h5 class="for-you2">
                                            Good for a Weekly Service
                                        </h5>
                                        <h2 class="title2">
                                            Light Home Cleaning
                                        </h2>
                                        <p class="for-you-text">
                                            This service will ensure that your home is clear of dust, filth, and
                                            debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                                        </p>
                                        <a class="btn btn-primary learn_srvbtn" href="{{ url('/customer/customer_services') }}">{{ __('Learn More') }}</a>
                                    </div>
                                </div>
                                <div>
                                    <img src="/images/services/deep_kitchen.jpg" class="bg-img1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="recom-service">
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <img src="/images/services/upholstery.jpg" class="bg-img">
                                </div>
                                <div class="card reco-service">
                                    <div class="services">
                                        <h5 class="for-you2">
                                            Recommended for Monthly
                                        </h5>
                                        <h2 class="title2">
                                            Deep Home Cleaning
                                        </h2>
                                        <p class="for-you-text">
                                            A deeper dive into maintaining a clean environment. This focuses all attention to every nook and crany. Makes sure that your space is clean and safe.
                                        </p>
                                        <a class="btn btn-primary learn_srvbtn" href="{{ url('/customer/customer_services') }}">{{ __('Learn More') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="recom-service">
                            <div class="row justify-content-center">
                                <div class="card reco-service1">
                                    <div class="services">
                                        <h5 class="for-you2">
                                            Good for Daily/Weekly Service
                                        </h5>
                                        <h2 class="title2">
                                            Maid for a Day Service
                                        </h2>
                                        <p class="for-you-text">
                                            This service will provide a worry-free day in the house by having a maid take care of the essential household chores.
                                            Four to eight hours a day with one to two maids, depending on the size of the residence.
                                        </p>
                                        <a class="btn btn-primary learn_srvbtn" href="{{ url('/customer/customer_services') }}">{{ __('Learn More') }}</a>
                                    </div>
                                </div>
                                <div>
                                    <img src="/images/services/maid1.jpg" class="bg-img1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#recommended" role="button" data-slide="prev">
                    <i class="fas fa-chevron-left back"></i>
                    <span class="sr-only">
                        Previous
                    </span>
                </a>
                <a class="carousel-control-next" href="#recommended" role="button" data-slide="next">
                    <i class="fas fa-chevron-right next"></i>
                    <span class="sr-only">
                        Next
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div class="mobile-spacer">
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </div>
</body>
@endsection