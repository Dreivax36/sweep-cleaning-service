<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Review;
    use App\Models\Notification;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Transaction
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><!-- jQuery base library needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light sweep-nav shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brandname" href="{{ url('/') }}">
                    SWEEP
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class= "navbar-nav ml-auto">    
                        <a href="admin_dashboard" class="nav-link">Home</a>
                        <a class="nav-link" href="admin_services" role="button">Services</a>
                        <a class="nav-link" href="admin_transaction" role="button" id="active">Transactions</a>
                        <a class="nav-link" href="admin_user" role="button">User</a>
                        <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
                        <li class="nav-item dropdown" id="admin">
                            <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                              ?>
                           <a id="navbarDropdown admin" class="nav-link"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-bell"></i> 
                                @if($notifCount != 0)
                                <span class="badge alert-danger pending">{{$notifCount}}</span>
                                @endif
                            </a>    
                            <div class="wrapper" id="notification">
                            @include('notification')
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $LoggedUserInfo['email'] }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" data-dismiss="modal" data-toggle="modal" data-target="#logout">
                                    Logout
                                </a>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
<body>

    <div class="col-sm-9">
            <div class="search_con"> <!-- Search Field -->
                <input class="form-control searchbar" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
            </div> 
        </div>
    </div>
    <?php
        $booking_data = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'On-the-Way')->orWhere('status', 'No-Available-Cleaner')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->orderBy('updated_at','DESC')->get();
        $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'On-the-Way')->orWhere('status', 'No-Available-Cleaner')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
        $history_count = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->count();
    ?>
    <div class="row user_btn_con"> <!-- Sub Header -->  
        <a class="user_type_btn" id="active"  href="admin_transaction">
            TRANSACTION 
            <p class="total_value">
                ({{ $transaction_count }})
            </p>
        </a>
        <a class="user_type_btn"  href="admin_transaction_history">
            HISTORY 
            <p class="total_value">
                ({{ $history_count }})
            </p>
        </a>
</div>
    <div class="transaction_con">
    
        <div class="row row_transaction">
        @if($booking_data != null )
        @foreach($booking_data as $key => $value)
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $userId = Customer::Where('customer_id', $value->customer_id )->value('user_id');
        $user_data = User::Where('user_id', $userId )->get();
        $address = Address::Where('customer_id', $value->customer_id )->value('address');
    ?>
            <div class="column col_transaction" id="card-lists">
                <div class="card card_transaction p-4">
                    <div class="d-flex card_body">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        @foreach($service_data as $key => $data)
                        <h3 class="card-title  service_title_trans">
                            {{ $data->service_name }}
                        </h3>
                        <?php
                           $numberOfCleaner = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->value('number_of_cleaner');
                           $pending = Assigned_cleaner::Where('booking_id', $value->booking_id)->where('status', 'Pending')->count();
                           $accept = Assigned_cleaner::Where('booking_id', $value->booking_id)->where('status', 'Accepted')->count();
                        ?>
                        <h5 class="service_status" id="status">
                            @if($value->status == 'Pending')
                                @if ($pending == 0)
                                    {{ $value->status }}
                                @else
                                    Waiting for Cleaner Acceptance
                                @endif    
                            @elseif($numberOfCleaner == $accept) 
                                Accepted by Cleaner
                            @else
                                {{ $value->status }}
                            @endif
                        </h5>
                    </div>
                    <div> 
                        <h6 class="booking_date">
                            <b>Scheduled:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }} </h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            @foreach($user_data as $user)
                            
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
                                        {{ $address }}
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
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Payment:
                                    </th>
                                    <td class="user_table_data">
                                        {{  $value->mode_of_payment }}
                                        @if ( $value->is_paid == true)
                                            <b> - Paid </b>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                            View Details
                        </button>
                    </div> 
                </div>
            </div>          
                    <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
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
                                
                                <form action="{{ route('updateStatus') }}" method="post" >
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
                                    <input type="hidden" name="service_id" value="{{ $value->service_id }}">
                                    
                                   
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
                                                <b>Address:</b> {{ $address }}
                                            </li>
                                            <br>
                                            <li>
                                                <b>Service:</b>
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                            </li>
                                            <?php
                                            $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();
                                            ?>
                                            @foreach($price as $price_data)
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
                                                <b>Price:</b> ₱{{ $price_data->price }}
                                            </li>
                                            <br>
                                            <li>
                                                <b>Payment:</b>
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Mode of Payment:</b> {{ $value->mode_of_payment }}
                                            </li>
                                            @if ( $value->mode_of_payment == 'Paypal')
                                            <li class="list_booking_info">
                                                <b>Paypal ID:</b> {{ $value->paypal_id }}
                                            </li>
                                            @endif
                                            @if ( $value->is_paid == true)
                                            <li class="list_booking_info">
                                                <b>Status:</b> Paid
                                            </li>
                                            @endif
                                            <br>
                                            <?php
                                                $id = Assigned_cleaner::Where('booking_id', $value->booking_id )->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                            ?> 
                                            
                                            <li>
                                                <b>Cleaners:</b>
                                            </li>
                                            @if($id != null)
                                            @foreach($id as $cleaner)
                                            <?php

                                                $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id )->value('user_id');
                                                $full = User::Where('user_id', $user_id )->value('full_name');

                                            ?>
                                            <li class="list_booking_info">
                                                <b>Name:</b> {{ $full }}
                                            </li>
                                            @endforeach  
                                            @endif
                                            
                                        </ul>
                                    
                                    
                                
                                <?php
                                    $bookingcount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->count();
                                    $statuscount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Accepted")->count();
                                    $declinecount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Declined")->count();
                                    $pendingcount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Pending")->count(); 
                                    $timeLimit = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Time-Limit-Reach")->count();
                               
                                ?>
                                <div class="modal-footer trans_modal_footer">
                                    @if($value->status == "Pending" && $declinecount == $price_data->number_of_cleaner && (strtotime($value->created_at) > strtotime("-1 hour")))
                                        <button  type="submit" class="btn btn-block btn-primary accept_btn" name="status" value="No-Available-Cleaner">
                                            NO AVAILABLE CLEANER
                                        </button>
                                    @endif
                                    @if($value->status == "Pending" && $statuscount != $price_data->number_of_cleaner && ($value->mode_of_payment == 'On-site' || $value->is_paid == true) && ( $declinecount != $price_data->number_of_cleaner || $declinecount == $price_data->number_of_cleaner || $timeLimit == $price_data->number_of_cleaner) && $pendingcount != $price_data->number_of_cleaner)
                                        <button type="button" class="btn btn-block btn-primary accept_btn" data-dismiss="modal" data-toggle="modal" data-target="#assign-{{ $value->booking_id }}">
                                            ASSIGN
                                        </button>
                                    @endif
                                    @if($value->status == "Pending" && $statuscount == $price_data->number_of_cleaner ) <!-- add is_paid -->
                                        <button  type="submit" class="btn btn-block btn-primary accept_btn" name="status" value="Accepted">
                                            ACCEPT
                                        </button>
                                    @endif
                                    @if($value->status == "Pending" && $bookingcount != $price_data->number_of_cleaner )    
                                        <button  type="submit" class="btn btn-block btn-primary decline_btn" data-toggle="modal" data-target="#decline-{{ $value->service_id }}"  data-dismiss="modal">
                                            DECLINE
                                        </button>
                                    @endif
                                    <?php
                                        $statusOnTheWay = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "On-the-Way")->count();
                                        $statusOnProgress = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "On-Progress")->count();
                                        $statusdone = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Done")->count();
                                        $reviews = Review::Where('booking_id', '=', $value->booking_id)->count();
                                    ?>
                                    @if($value->status == "Accepted" && $statusOnTheWay == $price_data->number_of_cleaner )
                                    <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-the-Way" >
                                        ON-THE-WAY
                                    </button>    
                                     @endif
                                    @if($value->status == "On-the-Way" && $statusOnProgress == $price_data->number_of_cleaner )
                                    <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-Progress" >
                                             ON-PROGRESS
                                         </button>    
                                     @endif    
                                    @if($value->status == "On-Progress" && $statusdone == $price_data->number_of_cleaner)
                                     <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Done" >
                                              DONE
                                     </button> 
                                     @endif 
                                     @if($value->status == "Done" && $value->is_paid == true && $reviews != 0)
                                     <button class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Completed" >
                                              COMPLETE
                                     </button> 
                                     @endif 
                                </div>
                                </form>
                            </div>
                        @endforeach  
                        @endforeach 
                        </div> <!-- End of Modal Content -->   
                            <div class="modal fade" id="decline-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('updateStatus') }}" method="post">
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
                                        Are you sure you want to decline this booking?
                                        <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                        <input type="hidden" name="status" value="Declined">
                                   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                        <button type="submit" class="btn btn-danger">YES</button>
                                    </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div><!-- End of Modal -->
                            <div class="modal-footer customer_services_modal_footer">
                                <div class="modal fade" id="assign-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal --> 
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content p-3 trans_modal_content">  <!-- Modal content-->
                                            <div class="modal-header trans_modal_header">
                                                <div class="d-flex pt-5">
                                                    <h4 class="modal_service_title_trans">
                                                        Assign Cleaner
                                                    </h4>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            
                                            <form action="{{ route('assignCleaner') }}" method="post" >
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
                                        
                                                    <?php  
                                                        $total = $price_data->number_of_cleaner;
                                                        $cleanerSchedule = Booking::Where('schedule_date', $value->schedule_date)->where('schedule_time', $value->schedule_time)->where('booking_id', '!=', $value->booking_id)->count();
                                                        $bookingSchedule = Booking::Where('schedule_date', $value->schedule_date)->where('schedule_time', $value->schedule_time)->where('booking_id', '!=', $value->booking_id)->get();
                                                        $cleaner_data = User::Where('user_type', 'Cleaner')->Where('account_status', 'Verified')->get(); 
                                                        $cleanerCount = Assigned_cleaner::Where('booking_id', $value->booking_id)->count();
                                                    ?>
                                                    @while($total > 0)
                                                        
                                                    <input type= "hidden" name="booking_id" value="{{ $value->booking_id }}">
                                                    <input type="hidden" name="status" value="Pending">
                                                    <label for="cleaner">Cleaner: </label>
                                                    <select name="cleaner_id[]" id="cleaner" class="form-control js-example-basic-single" data-live-search="true" style="width: 100%; max-height: 250px; overflow-y: auto;" aria-hidden="true">
                                                    @if($cleanerCount == 0) <!-- Booking does not exist in Assign Table -->
                                                        @if($cleanerSchedule == 0) <!-- Check if the booking have the no same Schedule -->
                                                            @if($cleaner_data != null) <!-- Check if Verified Cleaner exist-->
                                                                @foreach($cleaner_data as $key => $cleaner)
                                                                    <?php
                                                                        $fullname = User::Where('user_id', $cleaner->user_id )->value('full_name');
                                                                    ?>    
                                                                    <option  value="{{  $cleaner->user_id }}">{{ $fullname }}</option>
                                                                @endforeach 
                                                            @endif
                                                        @else <!-- Booking has the same Schedule -->
                                                            <?php  
                                                                $items = array();
                                                                $count = 0;
                                                                $itemExist = array();
                                                                $counter = 0;
                                                            ?>
                                                            @if($cleaner_data != null) <!-- Check if Verified Cleaner exist-->
                                                                @foreach($bookingSchedule as $key => $cleanerWithSchedule)
                                                                    <?php  
                                                                        $cleanerID = Assigned_cleaner::Where('booking_id', $cleanerWithSchedule->booking_id)->get();
                                                                    ?>
                                                                    @if($cleanerID != null) <!-- Check if booking already have a cleaner-->
                                                                        @foreach($cleaner_data as $key => $cleaner)                                
                                                                            @foreach($cleanerID as $key => $assignCleaner)
                                                                                <?php
                                                                                    $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id )->value('user_id');
                                                                                ?> 
                                                                                @if($cleaner->user_id == $assignUser)
                                                                                    <?php $itemExist[$counter++] =  $cleaner->user_id; ?>
                                                                                    @break
                                                                                @else
                                                                                    <?php $items[$count++] =  $cleaner->user_id; ?>
                                                                                @endif   
                                                                            @endforeach
                                                                        @endforeach 
                                                                    @endif 
                                                                @endforeach
                                                                <?php
                                                                    $items = array_unique($items);
                                                                    $itemExist = array_unique($itemExist);
                                                                    $final = array_diff($items,$itemExist);
                                                                ?>
                                        
                                                                @foreach($final as $userID)
                                                                    <?php
                                                                        $fullname = User::Where('user_id', $userID )->value('full_name');
                                                                    ?>    
                                                                    <option  value="{{  $userID }}">{{ $fullname }}</option>
                                                                @endforeach 
                                                            @endif
                                                        @endif
                                                    @else 
                                                        <?php  
                                                            $items = array();
                                                            $count = 0;
                                                        
                                                        ?>
                                                        @if($cleanerSchedule == 0)   <!-- Check if the booking have the no same Schedule --> 
                                                            @if($cleaner_data != null) <!-- Check if Verified Cleaner exist-->
                                                            <?php  
                                                                $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', 'Accepted')->orWhere('status', 'Declined')->orWhere('status', 'Pending')->get();        
                                                            ?>
                                                                @foreach($cleaner_data as $key => $cleaner)
                                                                    @foreach($cleanerID as $key => $assignCleaner)
                                                                        <?php
                                                                            $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id )->value('user_id');
                                                                        ?> 
                                                                        @if($cleaner->user_id != $assignUser)
                                                                            <?php $items[$count++] =  $cleaner->user_id; ?>
                                                                        @else
                                                                            @break
                                                                        @endif   
                                                                    @endforeach
                                                                @endforeach 
\                                                               <?php
                                                                    $items = array_unique($items);
                                                                ?>
                                                                @foreach($items as $userID)
                                                                    <?php
                                                                        $fullname = User::Where('user_id', $userID )->value('full_name');
                                                                    ?>    
                                                                        <option  value="{{  $userID }}">{{ $fullname }}</option>
                                                                @endforeach 
                                                            @endif
                                                        @else
                                                                <?php  
                                                                    $items = array();
                                                                    $count = 0;
                                                                    $itemExist = array();
                                                                    $counter = 0;
                                                                ?>
                                                            @if($cleaner_data != null)
                                                                @foreach($bookingSchedule as $key => $cleanerWithSchedule)
                                                                    <?php  
                                                                        $cleanerID = Assigned_cleaner::Where('booking_id', $cleanerWithSchedule->booking_id)->orWhere('booking_id', $value->booking_id)->get(); 
                                                                    ?>
                                                                    @if($cleanerID != null) <!-- Check if booking already have a cleaner-->
                                                                        @foreach($cleaner_data as $key => $cleaner)
                                                                            @foreach($cleanerID as $key => $assignCleaner)
                                                                                <?php
                                                                                    $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id )->value('user_id');
                                                                                ?> 
                                                                                @if($cleaner->user_id != $assignUser)
                                                                                    <?php $items[$count++] =  $cleaner->user_id; ?>
                                                                                @else
                                                                                    <?php $itemExist[$counter++] =  $cleaner->user_id; ?>
                                                                                    @break
                                                                                @endif     
                                                                            @endforeach
                                                                        @endforeach 
                                                                    @endif 
                                                                @endforeach
                                                                <?php
                                                                    $items = array_unique($items);
                                                                    $itemExist = array_unique($itemExist);
                                                                    $final = array_diff($items,$itemExist);
                                                                ?>
                                                                @foreach($final as $userID)
                                                                    <?php
                                                                        $fullname = User::Where('user_id', $userID )->value('full_name');
                                                                    ?>    
                                                                        <option  value="{{  $userID }}">{{ $fullname }}</option>
                                                                @endforeach 
                                                            @endif
                                                        @endif
                                                    @endif
                                                    </select> <br>  
                                                    <?php
                                                        $total --;
                                                    ?>
                                                    @endwhile
                                                <br>
                                                <div class="modal-footer trans_modal_footer">
                                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal"> 
                                                        Cancel 
                                                    </button>
                                                    <button type="submit" class="btn btn-block btn-primary accept_btn"> 
                                                        Confirm 
                                                    </button>
                                                </div>
                                            </form> 
                                        </div> <!-- End of Modal Content --> 
                                    </div>
                                </div>
                            </div>
                    @endforeach       
            @endforeach 
            @else
            <div class="banner-container">
            <div class="banner">
                <div class="text">
                    <h1> Currently no transaction.</h1>
                </div>
                <div class="image">
                    <img src="/images/services/header_img.png" class="img-fluid">
                </div>

            </div>
        </div>
            @endif 
        </div>
    </div>

   <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('21a2d0c6b21f78cd3195', {
    cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {
        
        
        var result = data.messages;
            var pending = parseInt($('#admin').find('.pending').html());
            if(pending) {
                $('#admin').find('.pending').html(pending + 1);
            }else{
                $('#admin').append('<span class="badge alert-danger pending">1</span>');
            } 
         
        });

        $('.read').click (function(event){
           
            id = event.target.id;
            $.ajax({
            method: "GET",
            url: "/read/" + id
            });
        });

    $('#admin').click( function(){
        
        $.ajax({
        type: "get",
        url: "/notification",
        data: "",
        cache: false,
        success:function(data) {
            $data = $(data);
            $('#notification').hide().html($data).fadeIn();
        }
        });
    }); 

    var channel = pusher.subscribe('my-channel');
        channel.bind('status', function(data) {
        var id = "{{ $LoggedUserInfo['user_id'] }}";
        if(data.id == id){
            $('#status').text(data.messages);
        }
    });

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    </script>  
    @if(!empty(Session::get('success')))
        <script>
            $(function(){
                $('#success').modal('show');
            });
        </script>
    @endif
    @if(!empty(Session::get('success-assign')))
        <script>
            $(function(){
                $('#success-assign').modal('show');
            });
        </script>
    @endif
    @if(!empty(Session::get('fail')))
        <script>
            $(function(){
                $('#error').modal('show');
            });
        </script>
    @endif
    
    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-check"></i>
            </div>
            <div class="title">
                Transaction Status Updated Successfully.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="success-assign" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-check"></i>
            </div>
            <div class="title">
                Cleaner assigned successfully.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <div class="title">
                Something went wrong, try again.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-sign-out-alt"></i>
            </div>
            <div class="title">
                Are you sure you want to logout?
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">Yes</button>
        </div>
        </div>
    </div>
    </div> 
    
    <footer id="footer">
    <div class="sweep-title">
        SWEEP © 2021. All Rights Reserved.
    </div>
</footer> 
</body>
@endsection
