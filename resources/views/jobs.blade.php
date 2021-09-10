@extends('head_extention_welcome') 

@section('content')
<head>
    <link href="{{ asset('css/jobs.css') }}" rel="stylesheet">
</head>
<div class="banner-container">
    <div class="banner">
            <div class="text">
                <h1>Join our Team</h1>
                <p>Join us in our mission on making homes clean one step at a time</p>
                <a class="btn btn-primary get_started_btn" href="#">{{ __('Get Started') }}</a>
            </div>
            <div class="image">
                <img src="/images/jobs/jobs-header.png" class="img-fluid">
            </div>     
                        
    </div>
</div>

<div class="more-info">
    <div class="row2">
    <div class="services">
            <h2 class="title2">Why join Sweep?</h2>
            <p class="for-you-text">Cleanliness starts with us. Specializing in various cleaning and assisting services, that would help lessen people’s burden by providing an extra set of hands enabling them to carry on with their lives with ease. </p>
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
