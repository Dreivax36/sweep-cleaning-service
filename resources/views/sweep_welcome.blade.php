@extends('head_extention_welcome') 

@section('content')
    <title>
        Welcome Page
    </title>
    <link href="{{ asset('css/style_welcome.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
<body>
   
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
    
</body>
@endsection