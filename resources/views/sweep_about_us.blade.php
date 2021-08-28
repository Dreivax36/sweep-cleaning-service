@extends('head_extention_welcome') 

@section('content')
    <title>
        About Us Page
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
                    <a class="nav_con active" href="sweep_about_us">
                        About Us
                    </a>
                </li>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar --> 

    <div class="about_con">
        <h2 class="about_title">
            ABOUT US
        </h2>
        <div class="d-flex">
            <div class="team_img_con">
                <img src="/img/team.jpg" class="d-block team_img" alt="..."> 
            </div>
            <div class="team_img_con">
                <img src="/img/team.jpg" class="d-block team_img" alt="..."> 
            </div>
            <div class="team_img_con">
                <img src="/img/team.jpg" class="d-block team_img" alt="..."> 
            </div>
        </div>
        <p class="about_caption">Co-owners, Duane, Lyka and Paul.</p>
        <h4 class="story_title">
            OUR STORY
        </h4>
        <div class="story_con">
            <p class="story_paragraph">
                Sweep is an application tailored to help busy people to maintain cleanliness and orderliness whether at home, in an apartment, or in an office. Our mission is to provide quality cleaning and assistance services that would lessen people’s burden by providing an extra set of hands enabling them to carry on with their lives with ease.
            </p>
            <p class="story_paragraph">
            Our vision is to establish ourselves as Bicolanos' first choice for online cleaning services in the city and, eventually, throughout the Bicol Region. Our objective is that everyone has the right to live and work in a clean, safe, and enjoyable environment.
            </p>
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