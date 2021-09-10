@extends('head_extention_welcome') 

@section('content')
<head>
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
</head>
<div class="banner-container">
    <div class="banner">
            <div class="text">
                <h1>The Road to Cleanliness has never been easier.</h1>
                <p>Making your comfort zones squeaky clean one step at a time.</p>
            </div>
            <div class="image">
                <img src="/images/services/header_img.png" class="img-fluid">
            </div>     
                        
    </div>
</div>
<div class="container-fluid">
    <div class="col-md-6">
        <div><h1> Services </h1></div>
    </div>
    <div class="row justify-content-center">
        <div class="card col-lg-3 col-md-5" style="width: 25rem;">
                <img class="card-img-top" src="images/services/general_cleaning.jpg" alt="Card image cap" >
                <div class="card-body">
                    <h3 class="card-title">General Cleaning</h3>
                    <p class="card-text">Comprises of sweeping, vacuuming, light dusting and a simple disinfection. This service will ensure that your home is clear of dust, filth, and debris.</p>
                    <a class="btn btn-primary" href="/customer/customer_login">Learn More</a> 
                    
                </div>
        </div>
        <div class="card col-lg-3 col-md-5" style="width: 25rem;">
                <img class="card-img-top" src="images/services/deep_cleaning.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">Deep Cleaning</h3>
                    <p class="card-text">A deeper dive into a clean environment, this service includes deep cleaning, bedroom organization, simple upholstery cleaning and simple disinfection.</p>
                    <a class="btn btn-primary" href="/customer/customer_login">Learn More</a>
                </div>
        </div>
        <div class="card col-lg-3 col-md-5" style="width: 25rem;">
                <img class="card-img-top" src="images/services/deep_kitchen.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">Deep Kitchen Cleaning</h3>
                    <p class="card-text">Designed exclusively for the kitchen, deep cleaning of countertops, stovetops, and ovens and simple management and disinfection.</p>
                    <a class="btn btn-primary" href="/customer/customer_login">Learn More</a>
                </div>
        </div>
        <div class="card col-lg-3 col-md-5" style="width: 25rem;">
                <img class="card-img-top" src="images/services/upholstery.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">Upholstery Cleaning</h3>
                    <p class="card-text">Concentrating on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance.</p>
                    <a class="btn btn-primary" href="/customer/customer_login">Learn More</a>
                </div>
        </div>
        <div class="card col-lg-3 col-md-5" style="width: 25rem;">
                <img class="card-img-top" src="images/services/maid.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">Maid for a Day</h3>
                    <p class="card-text">Have a worry-free day in the house by having a maid take care of the essential household chores. </p>
                    <a class="btn btn-primary" href="/customer/customer_login">Learn More</a>
                </div>
        </div>
        <div class="card col-lg-3 col-md-5" style="width: 25rem;">
                <img class="card-img-top" src="images/services/sanitation.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">Sanitation and Germ Proofing</h3>
                    <p class="card-text">This service will emphasize thorough sanitation, which will include disinfectant spray and antimicrobial fogging.</p>
                    <a class="btn btn-primary" href="/customer/customer_login">Learn More</a>
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
    
@endsection
