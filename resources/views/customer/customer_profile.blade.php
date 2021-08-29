<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Address;
?>
@extends('head_extention_customer') 

@section('content')
    <title>
        Customer Profile Page
    </title>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="customer_dashboard">
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

    <div class="col-2 d-flex customer_profile_title_con">
        <div>
            <h1 class="customer_cards_title">
                My Profile
            </h1> 
        </div>
    </div>

    <div class="main_profile_con d-flex">
        <div class="customer_profile_con">
            <div class="card customer_profile_avatar_con">
                <img class="card-img-top profile_avatar_img" src="/img/profile_avatar.png">
            </div>
        </div>
        <div class="d-flex flex-column">
        <div class="customer_profile_con">
            <div class="card customer_profile_avatar_con">
                <img class="card-img-top profile_avatar_img" src="{{asset('/storage/user/'.$LoggedUserInfo['profile_picture'] ) }}" alt="profile_picture" />
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="p-2 customer_profile_name_con">
                <h2 class="customer_profile_name" >
                    {{$LoggedUserInfo['full_name']}}
                </h2>
            </div>
            <div class="d-flex p-3 customer_profile_info_con">
                <div class="customer_profile_info_icon">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5 class="customer_profile_info">
                    {{$LoggedUserInfo['email']}}
                </h5>
            </div>
            <div class="d-flex p-3 customer_profile_info_con">
                <div class="customer_profile_info_icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <h5 class="customer_profile_info">
                    {{$LoggedUserInfo['contact_number']}}
                </h5>
            </div>

            <?php
                $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
                $address_data = Address::Where('customer_id', $customer_id )->get();
            ?>

            @foreach($address_data as $key => $value)
            <div class="d-flex p-3 customer_profile_info_con">
                <div class="customer_profile_info_icon">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <h5 class="customer_profile_info">
                    {{$value->address}}
                </h5>
            </div>
            @endforeach
        </div>
        <div class="update_btn_con"> <!-- Update Button -->
            <button type="button" class="btn btn-link customer_update_btn" data-toggle="modal" data-target="#exampleModalLong10">
                UPDATE
            </button>
        </div> <!-- End of Update Button -->
    </div>
</body>
@endsection