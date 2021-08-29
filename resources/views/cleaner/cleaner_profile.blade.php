@extends('head_extention_cleaner') 

@section('content')
    <title>
        Cleaner Profile Page
    </title>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="cleaner_dashboard">
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

    <div class="col-2 d-flex cleaner_profile_title_con">
        <div>
            <h1 class="cleaner_cards_title">
                My Profile
            </h1> 
        </div>
    </div>
    <div class="main_profile_con d-flex">
        <div class="cleaner_profile_con">
            <div class="card cleaner_profile_avatar_con">
                <img class="card-img-top profile_avatar_img" src="/img/profile_avatar.png">
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="p-2 cleaner_profile_name_con">
                <h2 class="cleaner_profile_name">
                    Lyka C. Casilao
                </h2>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5 class="cleaner_profile_info">
                    lycasilao@gbox.adnu.edu.ph
                </h5>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <h5 class="cleaner_profile_info">
                    09083095858
                </h5>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <h5 class="cleaner_profile_info">
                    Pacol, Naga City
                </h5>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <h5 class="cleaner_profile_info">
                    20
                </h5>
            </div>
        </div>
        
        <div class="update_btn_con"> <!-- Update Button -->
            <button type="button" class="btn btn-link cleaner_update_btn" data-toggle="modal" data-target="#exampleModalLong10">
                UPDATE
            </button>
        </div> <!-- End of Update Button -->
    </div>
</body>
@endsection