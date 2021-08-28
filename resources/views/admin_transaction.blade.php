<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Transaction
    </title>

<body>
<header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="admin_dashboard">
                        Home
                    </a>
                </li>
                <li>
                    <a href="admin_services">
                        Services
                    </a>
                </li>
                <li>
                    <a href="admin_transaction"  class="active">
                        Transaction
                    </a>
                </li>
                <li>
                    <a href="admin_user">
                        User
                    </a>
                </li>
                <li>
                    <a href="admin_payroll">
                        Payroll
                    </a>
                </li>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img class="profile_img" src="/img/user.png">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            Logout
                        </a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar -->

    <div class="row"> <!-- Sub Header -->  
        <a class="user_type_btn"  href="admin_transaction">
            TRANSACTION 
            <p class="total_value">
                (63)
            </p>
        </a>
        <a class="user_type_btn" id="active" href="admin_transaction_history">
            HISTORY 
            <p class="total_value">
                (63)
            </p>
        </a>
    </div>
    <div class="search_con"> <!-- Search Field -->
        <div>
            <input class="searchbar" type="text" placeholder="Search..">
            <button class="search_btn">
                Search
            </button>
        </div>
    </div> <!-- End of Search Field -->
    <p class="show_info"> 
        Showing 1-10 of 63 results 
    </p>
    <div class="result_con">
        <p class="show_info"> 
            Results per page: 
        </p>
        <button class="dropdown" id="number">
            10
            <span class="caret"></span>
        </button>
    </div>  <!-- End of Sub Header -->

    <?php
        $booking_data = Booking::all();
    ?>
    @foreach($booking_data as $key => $value)
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $user_data = User::Where('user_id', $value->customer_id )->get();
        $address_data = Address::Where('customer_id', $value->customer_id )->get();
        $price = Price::Where('property_type', $value->property_type )->get();
        $cleaner_data = User::Where('user_type', 'Cleaner' )->get();
    ?>
    @foreach($service_data as $key => $data)
    @foreach($price as $key => $price_data)
    @foreach($user_data as $key => $user)
    @foreach($address_data as $key => $address)

    <div class="transaction_con">
        <div class="row row_transaction">
            <div class="column col_transaction">
                <div class="card card_transaction p-4">
                    <div class="d-flex">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        <h3 class="service_title_trans">
                            Light Cleaning
                        </h3>
                        <h5 class="service_status">
                            Pending
                        </h5>
                    </div>
                    <div> 
                        <h6 class="booking_date">
                            <b>Data Created:</b> July 31, 2021
                        </h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Customer:
                                    </th>
                                    <td class="user_table_data">
                                        D. Bondad
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Address:
                                    </th>
                                    <td class="user_table_data">
                                        Palestina, Pili, Camarines Sur
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Contact Info:
                                    </th>
                                    <td class="user_table_data">
                                        09341562384
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 trans_modal_content"> <!-- Modal Content-->
                                <div class="modal-header trans_modal_header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check_icon_inside"></i>
                                    <h4 class="modal_service_title_trans">
                                        Light Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
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
                                            <b>Service:</b>
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Date:</b> July 31, 2021
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Cleaner/s:</b> 2
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Property Type:</b> Apartment
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Status:</b> Pending
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Price:</b> P376.00
                                        </li>     
                                    </ul>
                                </div>
                                <div class="modal-footer trans_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary accept_btn" data-dismiss="modal">
                                        ACCEPT 
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal">
                                        DECLINE 
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div>

            <div class="column col_transaction">
                <div class="card card_transaction p-4">
                    <div class="d-flex">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        <h3 class="service_title_trans">
                            Light Cleaning
                        </h3>
                        <h5 class="service_status">
                            Pending
                        </h5>
                    </div>
                    <div> 
                        <h6 class="booking_date">
                            <b>Data Created:</b> July 31, 2021
                        </h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Customer:
                                    </th>
                                    <td class="user_table_data">
                                        D. Bondad
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Address:
                                    </th>
                                    <td class="user_table_data">
                                        Palestina, Pili, Camarines Sur
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Contact Info:
                                    </th>
                                    <td class="user_table_data">
                                        09341562384
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 trans_modal_content"> <!-- Modal Content-->
                                <div class="modal-header trans_modal_header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check_icon_inside"></i>
                                    <h4 class="modal_service_title_trans">
                                        Light Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
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
                                            <b>Service:</b>
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Date:</b> July 31, 2021
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Cleaner/s:</b> 2
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Property Type:</b> Apartment
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Status:</b> Pending
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Price:</b> P376.00
                                        </li>     
                                    </ul>
                                </div>
                                <div class="modal-footer trans_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary accept_btn" data-dismiss="modal">
                                        ACCEPT 
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal">
                                        DECLINE 
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div>

            <div class="column col_transaction">
                <div class="card card_transaction p-4">
                    <div class="d-flex">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        <h3 class="service_title_trans">
                            Light Cleaning
                        </h3>
                        <h5 class="service_status">
                            Pending
                        </h5>
                    </div>
                    <div> 
                        <h6 class="booking_date">
                            <b>Data Created:</b> July 31, 2021
                        </h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Customer:
                                    </th>
                                    <td class="user_table_data">
                                        D. Bondad
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Address:
                                    </th>
                                    <td class="user_table_data">
                                        Palestina, Pili, Camarines Sur
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Contact Info:
                                    </th>
                                    <td class="user_table_data">
                                        09341562384
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 trans_modal_content"> <!-- Modal Content-->
                                <div class="modal-header trans_modal_header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check_icon_inside"></i>
                                    <h4 class="modal_service_title_trans">
                                        Light Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
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
                                            <b>Service:</b>
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Date:</b> July 31, 2021
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Cleaner/s:</b> 2
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Property Type:</b> Apartment
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Status:</b> Pending
                                        </li>
                                        <li class="list_booking_info">
                                            <b>Price:</b> P376.00
                                        </li>     
                                    </ul>
                                </div>
                                <div class="modal-footer trans_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary accept_btn" data-dismiss="modal">
                                        ACCEPT 
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal">
                                        DECLINE 
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div>


            <div class="column col_transaction">
                <div class="card card_transaction p-4">
                    <div class="d-flex">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        <h3 class="service_title_trans">
                            {{ $data->service_name }}
                        </h3>
                        <h5 class="service_status">
                            {{ $value->status }}
                        </h5>
                    </div>
                    <div> 
                        <h6 class="booking_date">
                            <b>Data Created:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }} </h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Customer:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $user->full_name }}
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Address:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $address->address }}
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Contact Info:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $user->contact_number }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 trans_modal_content"> <!-- Modal Content-->
                                <div class="modal-header trans_modal_header">
                                    <div class="d-flex pt-5">
                                        <i class="bi bi-card-checklist check_icon_inside"></i>
                                        <h4 class="modal_service_title_trans">
                                            {{ $data->service_name }}
                                        </h4>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <form action="{{ route('updateStatus') }}" method="post" id="myform">
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

                                    <div class="modal-body p-4">
                                        <ul class="customer_detail">
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
                                            <li>
                                                <b>Service:</b>
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Property Type:</b> {{ $value->property_type}}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Status:</b> {{ $value->status }}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Price:</b> P{{ $price_data->price }}
                                            </li>
                                            <br>

                                            <?php
                                                $cleaner_id = Cleaner::Where('cleaner_id', $value->cleaner_id )->value('user_id');
                                                $full = User::Where('user_id', $cleaner_id )->value('full_name');
                                            ?>
                                            
                                            <li>
                                                <b>Cleaners:</b>
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Name:</b> {{ $full }}
                                            </li>       
                                        </ul>
                                    </div>
                                
                                <div class="modal-footer trans_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary accept_btn" data-toggle="modal" data-target="#exampleModalLong101">
                                        ACCEPT
                                    </button>
                                    <button form="myform" type="submit" class="btn btn-block btn-primary decline_btn" name="status" value="Decline">
                                        DECLINE
                                    </button>
                                </div>
                                <div class="modal-footer customer_services_modal_footer">
                                <div class="modal fade" id="exampleModalLong101" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal --> 
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content p-3 trans_modal_content">  <!-- Modal content-->
                                            <div class="modal-header trans_modal_header">
                                                <div class="d-flex pt-5">
                                                    <h4 class="modal_service_title_trans">
                                                        Assign {{ $price_data->number_of_cleaner}} Cleaners
                                                    </h4>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            
                                            <form action="{{ route('updateStatus') }}" method="post" id="my">
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
                                                @foreach($cleaner_data as $key => $cleaner)
                    
                                                <br>
                                                <input type="hidden" name="service_id" value="{{ $value->service_id }}">
                                                <input type="checkbox" id="full_name" name="full_name" value="{{ $cleaner->full_name }}">
                                                <label for="full_name"> {{ $cleaner->full_name }}</label><br>
                                                @endforeach
                                                                
                                                <br>
                                                <div class="modal-footer trans_modal_footer">
                                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal"> 
                                                        Cancel 
                                                    </button>
                                                    <button form="my" type="submit" class="btn btn-block btn-primary accept_btn" name="status" value="Accepted"> 
                                                        Confirm 
                                                    </button>
                                                </div>
                                                  
                                        </div> <!-- End of Modal Content --> 
                                    </div>
                                </div>
                                </div>
                            </div> <!-- End of Modal Content -->   
                            </div>
                        </div> <!-- End of Modal -->
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
