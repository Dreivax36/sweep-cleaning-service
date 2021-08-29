@extends('head_extention_welcome') 

@section('content')
    <title>
        Welcome Page
    </title>

<body>
    <header> <!-- Navbar --> 
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a class="nav_con active" href="sweep_welcome">
                        Home
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="#">
                        Services
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="sweep_contact_us">
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
                <div class="dropdown login_con">
                    <div class="login_inside_con">
                        <button class="login_btn">
                            Log In
                        </button>
                        <div class="dropdown-content">
                            <a href="/customer/customer_login">Customer</a>
                            <a href="/cleaner/cleaner_login">Cleaner</a>
                        </div>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar --> 
    
    <div class="welcome_con">
        <div class="welcome_title_con">
            <h1 class="welcome_title">
                The Road to Cleanliness has never been easier.
            </h1>
        </div>
        <div class="welcome_sub_con">
            <h5 class="welcome_sub">
                Making your comfort zones squeaky clean one step at a time.
            </h5>
        </div>
        <div class="signup_con">
            <button type="button" class="btn btn-block btn-primary signup_btn"> 
                Sign Up 
            </button>
        </div>
    </div>
   
    <div class="welcome_fixed_footer"> <!-- Footer --> 
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