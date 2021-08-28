@extends('head_extention_cleaner') 

@section('content')
    <title>
        Cleaner Dashboard
    </title>
    <script type="text/javascript"  id="gwt-pst" src="{{ asset('js/sweep.js')}}"></script>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="cleaner_dashboard" class="active">
                        Home
                    </a>
                </li>
                <li>
                    <a href="cleaner_job">
                        Jobs
                    </a>
                </li>
                <li>
                    <a href="cleaner_history">
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
                    <a class="dropdown-item" href="cleaner_profile">
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
 
    <div class="row cleaner_row_dashboard"> <!-- Sidebar --> 
        <div class="col-sm-3 cleaner_side_con">
            <div class="local_time_con">
                <div id="pst-container">
                    <div class="local_time_title">
                        Philippine Standard Time
                    </div>
                    <div id="pst-time" class="local_time"></div>
                </div>
            </div>
            <h2 class="side_con_title">
                Available Jobs
            </h2>
            <div class="available_job_con"> 
                <div class="arrow_right_con">
                    <a href="#">
                        <span class="right"></span>
                    </a>
                </div>
                <h3 class="service_name">
                    Light Cleaning
                </h3>
                <h6 class="customer_info">
                    <b>Customer:</b> Lyka C. Casilao
                </h6>
                <h6 class="customer_info"> 
                    09341562384
                </h6>
                <h6 class="customer_info">
                    Palestina, Pili, Camarines Sur
                </h6>
            </div> 
        </div>
    </div> <!-- End of Sidebar -->
 
    <div class="customer_adjusted_search_con"> <!-- Search Field -->
        <form action="/action_page.php">
            <input type="text" placeholder="Search" name="search" class="customer_search_field">
        </form>
    </div> <!-- End of Search Field -->
</body>
@endsection