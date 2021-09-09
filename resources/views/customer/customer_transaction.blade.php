<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
?>

@extends('head_extention_customer') 

@section('content')
    <title>
        Customer Transaction Page
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
                    <a href="customer_transaction" class="active">
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
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
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

    <div class="col-2 d-flex customer_trans_title_con">
        <div>
            <h1 class="customer_cards_title">
                BOOKINGS
            </h1> 
        </div>
    </div>

    <?php
        $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
        $booking_data = Booking::Where('customer_id', $customer_id )->Where('status','!=', 'Declined' )->Where('status', '!=','Completed')->Where('status', '!=','Cancelled')->get();
    ?>
    

    <div class="customer_trans_con">
    @foreach($booking_data as $key => $value)
    
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();
    ?>
        <div class="column col_customer_trans">
            <div class="row row_customer_trans">
                <div class="card card_customer_trans p-4">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="customer_trans_broom_img p-1">
                        @foreach($service_data as $key => $data)
                        @foreach($price as $key => $price_data)
                        <div class="d-flex flex-column">
                            <h5 class="customer_trans_status">
                                {{ $value->status }}
                            </h5>
                            <h3 class="customer_trans_title">
                                {{ $data->service_name }}
                            </h3>
                            <h6 class="customer_trans_date_1_1">
                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                            </h6>
                            <h6 class="customer_trans_price_1">
                                P{{ $price_data->price }}
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link customer_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->booking_id }}">
                                    DETAILS
                                </button>
                                @if($value->status == "Accepted") 
                                <button type="button" class="btn btn-block btn-primary pay_btn" data-toggle="modal" data-target="#exampleModalLong1010-{{ $value->booking_id }}"> 
                                    Pay 
                                </button>
                                @endif
                                <div class="modal fade" id="exampleModalLong1010-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content customer_trans_modal_content_inside_inside"> <!-- Modal Content -->
                                            <div class="modal-header customer_trans_modal_header_inside_inside">
                                                <div class="p-3 modal_inside_inside_con">
                                                    <h3 class="customer_trans_title_pay">
                                                        {{ $data->service_name }}
                                                    </h3>
                                                    <h6 class="customer_trans_price_pay_1">
                                                        Total Amount: P{{ $price_data->price }}
                                                    </h6>
                                                    <div class="d-flex payments_con">
                                                        <img src="/img/gcash.png" class="gcash_img">
                                                        <script src="https://www.paypal.com/sdk/js?client-id=test"></script>
                                                        <script>paypal.Buttons().render('body');</script>
                                                    </div> 
                                                    <div class="d-flex cancel_confirm_pay_con">
                                                        <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> 
                                                            CANCEL 
                                                        </button>
                                                        <button type="button" class="btn btn-block btn-primary confirm_btn"> 
                                                            CONFIRM 
                                                        </button>
                                                    </div>  
                                                </div>
                                                <button type="button" class="close pl-2" data-dismiss="modal">&times;</button>
                                            </div>
                                        </div> <!-- End of Modal Content -->
                                    </div>
                                </div> <!-- End of Modal -->
                                @if($value->status == "Done")               
                                <button type="button" class="btn btn-block btn-primary rate_btn" data-toggle="modal" data-target="#exampleModalLong10101-{{ $value->service_id }}"> 
                                    Rate 
                                </button>
                                @endif
                                <div class="modal fade" id="exampleModalLong10101-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content customer_trans_his_modal_content_inside_inside">  <!-- Modal Content -->
                                            <div class="modal-header customer_trans_his_modal_header_inside_inside">
                                                <div class="p-1 customer_trans_his_modal_inside_con">
                                                    <h3 class="customer_trans_his_title_rate">
                                                        Rate the Service
                                                    </h3>
                                                    <h3 class="customer_trans_his_sub_rate">
                                                        Please let us know, how can we improve our service.
                                                    </h3>
                                                    <div class="provide_comment_con">
                                                        <form action="/action_page.php">
                                                            <textarea type="text" id="reason" class="provide_comment_field"></textarea>
                                                        </form>
                                                    </div>
                                                    <div class="d-flex cancel_confirm_pay_con">
                                                        <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> 
                                                            CANCEL 
                                                        </button>
                                                        <button type="button" class="btn btn-block btn-primary confirm_btn"  data-toggle="modal" data-target="#exampleModalLong101010"> 
                                                            SUBMIT 
                                                        </button>
                                                    </div>  
                                                    <div class="modal fade" id="exampleModalLong101010" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content customer_trans_his_modal_content_inside_inside">  <!-- Modal Content -->
                                                                <div class="modal-header customer_trans_his_modal_header_inside_inside">
                                                                    <div class="p-1 customer_trans_his_modal_inside_con">
                                                                        <h3 class="customer_trans_his_title_rate">
                                                                            Rate the Cleaner
                                                                        </h3>
                                                                        <select id="cleaners" name="cleaners" class="cleaners_dd">
                                                                            <option value="duane">
                                                                                Cleaner 1 - Duane
                                                                            </option>
                                                                            <option value="paul">
                                                                                Cleaner 2 - Paul
                                                                            </option>
                                                                            <option value="lyka">
                                                                                Cleaner 3 - Lyka
                                                                            </option>
                                                                        </select>
                                                                        <h3 class="customer_trans_his_comment">
                                                                            Comment
                                                                        </h3>
                                                                        <div class="provide_comment_con">
                                                                            <form action="/action_page.php">
                                                                                <textarea type="text" id="reason" class="provide_comment_field"></textarea>
                                                                            </form>
                                                                        </div>
                                                                        <div class="d-flex cancel_confirm_pay_con">
                                                                            <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> 
                                                                                CANCEL 
                                                                            </button>
                                                                            <button type="button" class="btn btn-block btn-primary confirm_btn"> 
                                                                                SUBMIT 
                                                                            </button>
                                                                        </div>  
                                                                    </div>
                                                                    <button type="button" class="close pl-2" data-dismiss="modal">&times;</button>
                                                                </div>
                                                            </div> <!-- End of Modal Content -->
                                                        </div>
                                                    </div> <!-- End of Modal -->
                                                </div>
                                                <button type="button" class="close pl-2" data-dismiss="modal">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="modal fade" id="exampleModalLong10-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content p-4 customer_trans_modal_content"> <!-- Modal Content -->
                                        <div class="modal-header customer_trans_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="customer_trans_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="customer_trans_modal_title">
                                                    {{ $data->service_name}}
                                                </h4>
                                                <h6 class="customer_trans_modal_date_1_1">
                                                    {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                </h6>
                                                <h6 class="customer_trans_modal_amount_1">
                                                    Total Amount: P{{ $price_data->price }}
                                                </h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_trans_modal_body_1_con">
                                            <p class="customer_trans_description">
                                                {{ $data->description}}                                            </p>
                                            <ul class="customer_package_list">
                                                <li>
                                                    <b>Equipment:</b> {{ $data->equipment }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Materials:</b> {{ $data->material }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Personal Protection:</b> {{ $data->personal_protection }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Property Type:</b> {{ $value->property_type }}
                                                </li>    
                                                <li>
                                                    <b>Cleaners:</b> {{ $price_data->number_of_cleaner }}
                                                </li>     
                                            </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer customer_trans_modal_footer">
                                        @if($value->status != "On-Progress") 
                                            <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-toggle="modal" data-target="#canceltransaction-{{ $value->booking_id }}" >
                                                CANCEL
                                            </button>
                                        @endif
                                            <div class="modal fade" id="canceltransaction-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content customer_trans_modal_content_inside"> <!-- Modal Content -->
                                                        <div class="modal-header customer_trans_modal_header_inside">
                                                            <div class="p-3 customer_trans_modal_inside_con">
                                                                <h3 class="cancel_booking_question">
                                                                    Are you sure you want to cancel your booking?
                                                                </h3>
                                                                <form action="{{ route('updateStatus') }}" method="post" id="updateStatus">
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
                                                                <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                                                </form>   
                                                                <div class="d-flex no_yes_con">
                                                                    <button type="button" class="btn btn-block btn-primary no_btn" data-dismiss="modal"> 
                                                                        NO 
                                                                    </button>
                                                                    <button type="submit" form="updateStatus"  class="btn btn-block btn-primary yes_btn" name="status" value="Cancelled"> 
                                                                        YES 
                                                                    </button>
                                                                </div>
                                                                
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    </div> <!-- End of Modal Content -->
                                                </div>
                                            </div> <!-- End of Modal -->
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
        @endforeach
    @endforeach
    @endforeach

    </div>

</body>
@endsection