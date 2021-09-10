@extends('head_extention_welcome') 

@section('content')
<head>
    <link href="{{ asset('css/jobs.css') }}" rel="stylesheet">
</head>
<div class="banner-container">
    <div class="banner">
            <div class="text">
                <h1>Contact Us</h1>
                <p>Join us in our mission on making homes clean one step at a time</p>
                <a class="btn btn-primary get_started_btn" href="#">{{ __('Get Started') }}</a>
            </div>
            <div class="image">
                <img src="/images/jobs/jobs-header.png" class="img-fluid">
            </div>     
                        
    </div>
</div>

<div class="contact_form_con d-flex">
    <div class="contact_form_main_con">
        <div class="form-group">
            <input type="text" class="form-control contact_fields" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}">
            <span class="text-danger">
                @error('full_name'){{ $message }} @enderror
            </span>
        </div>
        <div class="form-group">
            <input type="text" class="form-control contact_fields" name="email" placeholder="Email" value="{{ old('email') }}">
            <span class="text-danger">
                @error('email'){{ $message }} @enderror
            </span>
        </div>
        <div class="form-group">
            <textarea type="text" class="form-control contact_fields" name="message" placeholder="Message" value="{{ old('message') }}"></textarea>
            <span class="text-danger">
                @error('message'){{ $message }} @enderror
            </span>
        </div>
        <button type="button" class="btn btn-block btn-primary contact_us_btn">
            Contact Us
        </button>
    </div>
    <div class="contact_side_con">
        <h5 class="contact_side_con_title">
            Contact 
        </h5> 
        <p class="contact_side_info">
            sweep_service@gmail.com
        </p>
        <h5 class="contact_side_con_title">
            Based in
        </h5> 
        <p class="contact_side_info">
            Naga City, Camarines Sur
        </p>
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
