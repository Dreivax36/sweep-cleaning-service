@extends('head_extention_welcome') 

@section('content')
    <title>
        FAQs Page
    </title>
<body>
    <header> <!-- Navbar --> 
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a class="nav_con" href="sweep_welcome">
                        Home
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="#">
                        Services
                    </a>
                </li>
                <li>
                    <a class="nav_con active" href="sweep_contact_us">
                        Contact Us
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="sweep_faqs">
                        FAQs
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="sweep_about_us">
                        About Us
                    </a>
                </li>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar --> 
    
    <div class="contact_con d-flex">
        <div class="side_img_con">
            <img src="/img/side.jpg" class="d-block side_img" alt="..."> 
        </div>
        <div class="d-flex">
            <div>
                <h2 class="contact_title">
                    Contact Us
                </h2>
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
            </div>
        </div>
    </div>

    <div class="fixed_footer"> <!-- Footer --> 
        <div class="d-flex">
            <div class="footer_info_con">
                <h5>
                    Do You Want Squeacky-Clean Floors?
                </h5>
                <p>
                    Call <u class="contact_no">09897656345</u> today to get a free estimate on our services.
                </p>
            </div>
            <div class="footer_info_con">
                <p>
                    When you need regular cleaning services for your house, you can rely on the professionals at SWEEP to provide them for you. We're available for recurring cleaning services and short-notice deep cleans when you're preparing for important guests.
                </p>
            </div>
            <div class="form-group footer_sign_con">
            <input type="text" placeholder="Email" class="form-control signup_field">
            <button type="button" class="btn btn-block btn-primary footer_signup_btn"> 
                Sign Up Now
            </button>
        </div>
        </div>
        <div class="footer_content">
            Copyright &copy; 2021 Ateneo de Naga University
        </div>        
    </div> <!-- End of Footer -->
    
</body>
@endsection