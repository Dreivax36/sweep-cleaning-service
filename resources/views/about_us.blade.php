@extends('head_extention_welcome') 

@section('content')
<head>
    <link href="{{ asset('css/jobs.css') }}" rel="stylesheet">
</head>
<div class="banner-container">
    <div class="banner">
            <div class="text">
                <h1>About Us</h1>
                <p>Relax! Have a worry-free lifestyle</p>
            </div>
            <div class="image">
                <img src="/images/jobs/jobs-header.png" class="img-fluid">
            </div>     
                        
    </div>
</div>

<div class="more-info">
    <div class="row2">
    <div class="services">
            <h2 class="title2">For a cleaner, fresher home. Always!</h2>
            <p class="for-you-text">Sweep is a local start-up enterprise based in Naga City. Founded by three students with the goal in mind to make sure everyone would live and work in a clean, safe, and enjoyable environment. <br></p>
            <p class="for-you-text">Specializing in various cleaning and assisting services, that would help lessen people’s burden by providing an extra set of hands enabling them to carry on with their lives with ease.</p>
        </div>
        <div class="col-6">
            <img src="images/jobs/headhome.png" class="img-fluid">
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
