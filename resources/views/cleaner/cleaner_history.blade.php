@extends('head_extention_cleaner') 

@section('content')
    <title>
        Cleaner History Page
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
                    <a href="cleaner_history" class="active">
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

    <div class="customer_search_con"> <!-- Search Field -->
        <form action="/action_page.php">
            <input type="text" placeholder="Search" name="search" class="customer_search_field">
        </form>
    </div> <!-- End of Search Field -->
   
    <div class="col-2 d-flex cleaner_job_title_con">
        <div>
            <h1 class="cleaner_cards_title">
                History 
            </h1> 
        </div>
    </div>
    <div class="cleaner_job_con">
        <div class="column col_cleaner_job">
            <div class="row row_cleaner_job">
                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">
                        <div class="d-flex flex-column">
                            <h5 class="cleaner_job_status">
                                Pending
                            </h5>
                            <h3 class="cleaner_job_title">
                                Light Cleaning
                            </h3>
                            <h6 class="cleaner_job_date_1_1">
                                July 22, 2021
                            </h6>
                            <h6 class="cleaner_job_price_1">
                                P545.00
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS
                                </button>
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content p-4 cleaner_job_modal_content"> <!-- Modal Content-->
                                        <div class="modal-header cleaner_job_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="cleaner_job_modal_title">
                                                    Light Cleaning
                                                </h4>
                                                <h6 class="cleaner_job_modal_date_1_1">
                                                    July 22, 2021
                                                </h6>
                                                <h6 class="cleaner_job_modal_amount_1">
                                                    Total Amount: P545.00
                                                </h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="cleaner_job_modal_body_1_con">
                                                <ul class="cleaner_detail">
                                                    <li>
                                                        <b>Customer:</b>
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Name:</b> Duane Xavier Bondad
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Contact Number:</b> 09341562384
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Address:</b> Palestina, Pili, Camarines Sur
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Service Details:</b>
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Property Type:</b> Apartments
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Time:</b> 1:00 PM
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Cleaner/s:</b> 3
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Status:</b> On Progress
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Feedback:</b>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer cleaner_job_modal_footer">

                                        </div>
                                    </div> <!-- End of Modal Content --> 
                                    </div>
                                </div> <!-- End of Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column col_cleaner_job">
            <div class="row row_cleaner_job">
                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">
                        <div class="d-flex flex-column">
                            <h5 class="cleaner_job_status">
                                Pending
                            </h5>
                            <h3 class="cleaner_job_title">
                                Light Cleaning
                            </h3>
                            <h6 class="cleaner_job_date_1_1">
                                July 22, 2021
                            </h6>
                            <h6 class="cleaner_job_price_1">
                                P545.00
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS
                                </button>
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content p-4 cleaner_job_modal_content"> <!-- Modal Content-->
                                        <div class="modal-header cleaner_job_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="cleaner_job_modal_title">
                                                    Light Cleaning
                                                </h4>
                                                <h6 class="cleaner_job_modal_date_1_1">
                                                    July 22, 2021
                                                </h6>
                                                <h6 class="cleaner_job_modal_amount_1">
                                                    Total Amount: P545.00
                                                </h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="cleaner_job_modal_body_1_con">
                                                <ul class="cleaner_detail">
                                                    <li>
                                                        <b>Customer:</b>
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Name:</b> Duane Xavier Bondad
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Contact Number:</b> 09341562384
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Address:</b> Palestina, Pili, Camarines Sur
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Service Details:</b>
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Property Type:</b> Apartments
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Time:</b> 1:00 PM
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Cleaner/s:</b> 3
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Status:</b> On Progress
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Feedback:</b>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer cleaner_job_modal_footer">

                                        </div>
                                    </div> <!-- End of Modal Content --> 
                                    </div>
                                </div> <!-- End of Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column col_cleaner_job">
            <div class="row row_cleaner_job">
                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">
                        <div class="d-flex flex-column">
                            <h5 class="cleaner_job_status">
                                Pending
                            </h5>
                            <h3 class="cleaner_job_title">
                                Light Cleaning
                            </h3>
                            <h6 class="cleaner_job_date_1_1">
                                July 22, 2021
                            </h6>
                            <h6 class="cleaner_job_price_1">
                                P545.00
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS
                                </button>
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content p-4 cleaner_job_modal_content"> <!-- Modal Content-->
                                        <div class="modal-header cleaner_job_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="cleaner_job_modal_title">
                                                    Light Cleaning
                                                </h4>
                                                <h6 class="cleaner_job_modal_date_1_1">
                                                    July 22, 2021
                                                </h6>
                                                <h6 class="cleaner_job_modal_amount_1">
                                                    Total Amount: P545.00
                                                </h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="cleaner_job_modal_body_1_con">
                                                <ul class="cleaner_detail">
                                                    <li>
                                                        <b>Customer:</b>
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Name:</b> Duane Xavier Bondad
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Contact Number:</b> 09341562384
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Address:</b> Palestina, Pili, Camarines Sur
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Service Details:</b>
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Property Type:</b> Apartments
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Time:</b> 1:00 PM
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Cleaner/s:</b> 3
                                                    </li>
                                                    <li class="list_booking_info">
                                                        <b>Status:</b> On Progress
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Feedback:</b>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer cleaner_job_modal_footer">

                                        </div>
                                    </div> <!-- End of Modal Content --> 
                                    </div>
                                </div> <!-- End of Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $booking_data = Booking::Where('status', 'Done')->get();
        ?>
        @foreach($booking_data as $key => $value)

        <?php
            $service_data = Service::Where('service_id', $value->service_id )->get();
            $user_data = User::Where('user_id', $value->customer_id )->get();
            $address_data = Address::Where('customer_id', $value->customer_id )->get();
            $price = Price::Where('property_type', $value->property_type )-> Where('service_id', $value->service_id )->get();
            $cleaner_data = User::Where('user_type', 'Cleaner' )->get();
        ?>

        <div class="column col_cleaner_job">
            <div class="row row_cleaner_job">
                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">  
                        <div class="d-flex flex-column">
                            <h5 class="cleaner_job_status">
                                {{ $value->status }}
                            </h5>
                            @foreach($service_data as $key => $data)
                            <h3 class="cleaner_job_title">
                                {{ $data->service_name}}
                            </h3>
                            <h6 class="cleaner_job_date_1_1">
                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                            </h6>
                             @foreach($price as $key => $price_data)
                            <h6 class="cleaner_job_price_1">
                                P{{ $price_data->price }}
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS
                                </button>
                                
                                @foreach($user_data as $key => $user)
                                @foreach($address_data as $key => $address)
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('updateStatus') }}" method="post" id="myform"> <!-- Modal Content -->
                                            @if(Session::get('success'))
                                                <div class="alert alert-success">
                                                    {{ Session::get('success') }}
                                                </div>
                                            @endif

                                            @if(Session::get('fail'))
                                                <div class="alert alert-danger">
                                                    {{ Session::get('fail') }}
                                                </div>
                                            @endif
                                            @csrf
                                        
                                            <input type="hidden" name="service_id" value="{{ $value->service_id }}">
                                            <div class="modal-content p-4 cleaner_job_modal_content">
                                                <div class="modal-header cleaner_job_modal_header">
                                                    <div class="d-flex pt-5">
                                                        <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="cleaner_job_modal_title">
                                                                {{ $data->service_name }}
                                                            </h4>
                                                            <h6 class="cleaner_job_modal_date_1_1">
                                                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                            </h6>
                                                            <h6 class="cleaner_job_modal_amount_1">
                                                                Total Amount: P{{ $price_data->price }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body d-flex p-4">
                                                    <div class="cleaner_job_modal_body_1_con">
                                                        <ul class="cleaner_detail">
                                                            <li>
                                                                <b>Customer:</b>
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Name:</b> {{ $user->full_name }}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Contact Number:</b> {{ $user->contact_number }}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Address:</b> {{ $address->address }}
                                                            </li>
                                                            <br>
                                                            <li><b>Service Details:</b></li>
                                                            <li class="list_booking_info">
                                                                <b>Property Type:</b> {{ $value->property_type}}<
                                                                    /li>
                                                            <li class="list_booking_info">
                                                                <b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Status:</b> {{ $value->status }}
                                                            </li>
                                                            <br>
                                                            <li>
                                                                <b>Feedback:</b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal-footer cleaner_job_modal_footer">

                                                </div>
                                            </div> 
                                            <!-- End of Modal Content -->
                                    </div>
                                </div> <!-- End of Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endforeach
    @endforeach
    @endforeach
    @endforeach
    @endforeach
</body>
@endsection