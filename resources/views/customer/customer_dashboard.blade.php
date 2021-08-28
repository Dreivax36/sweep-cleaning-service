@extends('head_extention_customer') 

@section('content')
    <title>
        Customer Dashboard Page
    </title>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="customer_dashboard" class="active">
                        Home
                    </a>
                </li>
                <li>
                    <a href="customer_services">
                        Services
                    </a>
                </li>
                <li>
                    <a href="customer_transaction">
                        Transaction
                    </a>
                </li>
                <li>
                    <a href="customer_history">
                        History
                    </a>
                </li>
                <div class="customer_notif_icon">
                    <button class="btn dropdown-toggle dropdown_notif_icon" type="button" id="menu2" data-toggle="dropdown" >
                        <i class="bi bi-bell"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">
                        Notification 1
                    </a>
                    <a class="dropdown-item" href="#">
                        Notification 2
                    </a>
                </div>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img src="/img/user.png" class="profile_img">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="customer_profile">
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            Logout
                        </a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar -->
   
    <div class="customer_dashboard_con"> <!-- Carousel -->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/img/carousel_1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>
                        Light Cleaning
                    </h2>
                    <p>
                        Focus on high-touch surfaces such as doorknobs, tables, handles, light switches, and countertops.
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/carousel_2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>
                        Deep Home Cleaning
                    </h2>
                    <p>
                        Clean other surfaces in your home when they are visibly dirty or as needed. You might also choose to disinfect.
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/carousel_3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>
                        Deep Kitchen Cleaning
                    </h2>
                    <p>
                        Taking special care when cleaning surfaces, equipment, sinks and taps, and general storage areas.
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/carousel_4.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>
                        Upholstery Cleaning
                    </h2>
                    <p>
                        Keeping your upholstery clean will maintain its appearance, keeping colours bright and textures as they should be.
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/carousel_5.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>
                        Maid for a Day
                    </h2>
                    <p>
                        It allows you to create a schedule for services when it is most beneficial for you and your family.
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/img/carousel_6.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>
                        Sanitation and Germ Proofing
                    </h2>
                    <p>
                        Sanitation systems aim to protect health by providing and promoting a clean environment.
                    </p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">
                Previous
            </span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">
                Next
            </span>
        </button>  <!-- End of Carousel -->
        <div class="container-fluid customer_dashboard_center_con">
            <h2 class="center_dasboard_title">
                Do You Want Squeacky-Clean Floors?
            </h2>
            <h5>
                ASK US ABOUT OUR CLEANING SERVICES
            </h5>
            <h6>
                Call <u class="contact_no">09897656345</u> today to get a free estimate on our services.
            </h6>
        </div>
        <div class="customer_dashboard_center_con_1">
            <div class="marketing_con">
                <h5 class="center_dasboard_head">
                    LET US KEEP YOUR HOUSE CLEAN FOR YOU
                </h5>
                <h6 class="center_dasboard_paragraph">
                    When you need regular cleaning services for your house, you can rely on the professionals at SWEEP to provide them for you. We're available for recurring cleaning services and short-notice deep cleans when you're preparing for important guests.
                </h6>
            </div>
        </div>
        <div class="col">
            <div class="left_content_con">
                <h4 class="left_content_title">
                    Don't Let Your Home Get Dirty
                </h4>
                <h6>
                    HAVE YOUR HOME PROFESSIONALLY CLEANED
                </h6>
                <p class="left_content_paragraph">
                    Keeping your property clean is an important part of having a family. If your home seems junky or disorderly, your family might have a hard time living, and guest might begin to view you in a negative light. The professional team at SWEEP will make sure every square inch of your home property looks its best.
                </p>
                <p class="left_content_paragraph">
                    You can hire us for recurring cleaning services that fit your schedule. Our team can clean everything from small residential property to medium condominiums and even aprtments.
                </p>
            </div>
            <div class="right_content_con">
                <img src="/img/clean_home.jpg" class="d-block home_img" alt="..."> 
            </div>
        </div>
    </div>
   
    <div class="customer_dashboard_footer"> <!-- Footer -->
        <div class="footer_search_con"> <!-- Search Field -->
            <form action="/action_page.php">
                <input type="text" placeholder="Search" name="search" class="customer_search_field">
            </form>
        </div> <!-- End of Search Field -->
        <div class="customer_dashboard_footer_content">
            Copyright &copy; 2021 Ateneo de Naga University
        </div>
        <div class="d-flex">
            <div class="row">
                <div class="footer_nav_con">
                    <h5>
                        <a href="customer_dashboard" class="footer_nav_title active">
                            Home
                        </a>
                    </h5>
                    <h5>
                        <a href="customer_services" class="footer_nav_title">
                            Services
                        </a>
                    </h5>
                    <h5>
                        <a href="customer_transaction" class="footer_nav_title">
                            Transaction
                        </a>
                    </h5>
                    <h5>
                        <a href="customer_history" class="footer_nav_title">
                            History
                        </a>
                    </h5>
                </div>
            </div>  
            <div class="row">
                <div class="footer_nav_con">
                    <h5>
                        <a href="#" class="footer_nav_title">
                            Contact Us
                        </a>
                    </h5>
                    <h5>
                        <a href="#" class="footer_nav_title">
                            FAQs
                        </a>
                    </h5>
                    <h5>
                        <a href="#" class="footer_nav_title">
                            About Us
                        </a>
                    </h5>
                </div>
            </div>
        </div>
    </div>  <!-- End of Footer --> 
</body>
@endsection