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

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_transactions.css')}}">
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
                <ul class="navbar-nav ml-auto">
                    <a href="admin_dashboard" class="nav-link">Home</a>
                    <a class="nav-link" href="admin_services" role="button">Services</a>
                    <a class="nav-link" href="admin_transaction" role="button" id="active">Transactions</a>
                    <a class="nav-link" href="admin_user" role="button">User</a>
                    <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
                    <a class="nav-link" href="admin_reports" role="button">Reports</a>
                    <li class="nav-item dropdown" id="admin">
                        <?php
                        $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                        $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                        ?>
                        <a id="navbarDropdown admin" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-bell"></i>
                            @if($notifCount != 0)
                            <span class="badge alert-danger admin_transaction">{{$notifCount}}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                            @forelse ($notif as $notification)
                            <a class="dropdown-item read" id="refresh" href="/{{$notification->location}}/{{$notification->id}}">
                                {{ $notification->message}}
                            </a>

                            @empty
                            <a class="dropdown-item">
                                No record found
                            </a>
                            @endforelse
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

<body id="status">


    <?php
    $booking_data = Booking::Where('status', 'Accepted')->orderBy('updated_at', 'DESC')->get();
    $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'On-the-Way')->orWhere('status', 'No-Available-Cleaner')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
    $history_count = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->count();
    ?>
    <div class="row">
        <div class="header">
            <div class="user_btn_con">
                <!-- Sub Header -->
                <a class="user_type_btn" id="active" href="admin_transaction">
                    TRANSACTION
                    <p class="total_value">
                        ({{ $transaction_count }})
                    </p>
                </a>
                <a class="user_type_btn" href="admin_transaction_history">
                    HISTORY
                    <p class="total_value">
                        ({{ $history_count }})
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="sub_menu">
        <div class="user_btn_con1">
            <!-- Sub Menu -->
            <?php
                $pendingSub = Booking::where('status', 'Pending')->count();
                $acceptedSub = Booking::where('status', 'Accepted')->count();
                $onthewaySub = Booking::where('status', 'On-the-Way')->count();
                $onprogressSub = Booking::where('status', 'On-Progress')->count();
                $doneSub = Booking::where('status', 'Done')->count();
            ?>
            <a class="user_type_btn" href="admin_transaction">
                PENDING
                @if($pendingSub != 0)
                <p class="total_value1">
                    ({{$pendingSub}})
                </p>
                @endif
            </a>
            <a class="user_type_btn" id="active" href="accepted">
                ACCEPTED
                @if($acceptedSub != 0)
                <p class="total_value1">
                    ({{$acceptedSub}})
                </p>
                @endif
            </a>
            <a class="user_type_btn" href="on_the_way">
                ON-THE-WAY
                @if($onthewaySub != 0)
                <p class="total_value1">
                    ({{$onthewaySub}})
                </p>
                @endif
            </a>
            <a class="user_type_btn"  href="on_progress">
                ON-PROGRESS
                @if($onprogressSub != 0)
                <p class="total_value1">
                    ({{$onprogressSub}})
                </p>
                @endif
            </a>
            <a class="user_type_btn" href="done">
                DONE
                @if($doneSub != 0)
                <p class="total_value1">
                    ({{$doneSub}})
                </p>
                @endif
            </a>
           
        </div>
    </div>

    <div class="body">
    <div class="row row_transaction justify-content-center">
        @if($booking_data != null )
        @foreach($booking_data as $key => $value)
        <?php
        $service_data = Service::Where('service_id', $value->service_id)->get();
        $customerid = $value->customer_id;
        $userId = Customer::Where('customer_id', $customerid)->value('user_id');
        $user_data = User::Where('user_id', $userId)->get();
        $address = Address::Where('customer_id', $customerid)->value('address');
        ?>
        <div class="card card_transaction mb-3" style="width: 25rem;">
            <div class="card_body">
                <?php
                $numberOfCleaner = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->value('number_of_cleaner');
                $admin_transaction = Assigned_cleaner::Where('booking_id', $value->booking_id)->where('status', 'Pending')->count();
                $accept = Assigned_cleaner::Where('booking_id', $value->booking_id)->where('status', 'Accepted')->count();
                ?>
                <div class="status">
                    <h5 class="service_trans_status">
                        @if($value->status == 'Pending')
                        @if ($admin_transaction == 0)
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
                @foreach($service_data as $key => $data)
                <h3 class="card-title service_title_trans">
                    {{ $data->service_name }}
                </h3>
                <div>
                    <h6 class="booking_date">
                        <b>Scheduled:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                    </h6>
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
                                    {{ $value->mode_of_payment }}
                                    @if ( $value->is_paid == true)
                                    <b> - Paid </b>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card-footer">
                <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                    View Details
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <!-- Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content trans_modal_content">
                <!-- Modal Content-->
                <div class="modal-header trans_modal_header">
                    <div class="d-flex pt-5">
                        <i class="bi bi-card-checklist check_icon_inside"></i>
                        <h4 class="modal_service_title_trans">
                            {{ $data->service_name }}
                        </h4>
                    </div>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateStatus') }}" method="post">
                        @if(Session::has('success'))
                        <script>
                            swal({
                                title: "Transaction Status Updated Successfully!",
                                icon: "success",
                                button: "Close",
                            });
                        </script>
                        @endif
                        @if(Session::get('fail'))
                        <script>
                            swal({
                                title: "Something went wrong, try again!",
                                icon: "error",
                                button: "Close",
                            });
                        </script>
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
                            $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->get();
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
                            $id = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                            ?>

                            <li>
                                <b>Cleaners:</b>
                            </li>
                            @if($id != null)
                            @foreach($id as $cleaner)
                            <?php

                            $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id)->value('user_id');
                            $full = User::Where('user_id', $user_id)->value('full_name');

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
                        $admin_transactioncount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Pending")->count();
                        $timeLimit = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Time-Limit-Reach")->count();

                        ?>
                </div>
                <div class="modal-footer trans_modal_footer">
                    
                    <?php
                    $statusOnTheWay = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "On-the-Way")->count();
                    $statusOnProgress = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "On-Progress")->count();
                    $statusdone = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Done")->count();
                    $reviews = Review::Where('booking_id', '=', $value->booking_id)->count();
                    ?>
                   @if($value->status == "Accepted" && $statusOnTheWay == $price_data->number_of_cleaner )
                    <button class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-the-Way">
                        ON-THE-WAY
                    </button>
                    @endif
                </div>
                </form>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
    <div class="modal-footer customer_services_modal_footer">
        <div class="modal fade" id="assign-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <!-- Modal -->
            <div class="modal-dialog" role="document">
                <div class="modal-content trans_modal_content">
                    <!-- Modal content-->
                    <div class="modal-header trans_modal_header">
                        <div class="d-flex pt-5">
                            <h4 class="modal_service_title_trans">
                                Assign Cleaner
                            </h4>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="{{ route('assignCleaner') }}" method="post">
                        @if(Session::get('success-assign'))
                        <script>
                            swal({
                                title: "Cleaner assigned successfully!",
                                icon: "success",
                                button: "Close",
                            });
                        </script>
                        @endif

                        @if(Session::get('fail'))
                        <script>
                            swal({
                                title: "Something went wrong, try again!",
                                icon: "error",
                                button: "Close",
                            });
                        </script>
                        @endif
                        @csrf

                        <?php
                        $total = $price_data->number_of_cleaner;
                        $cleanerSchedule = Booking::Where('schedule_date', $value->schedule_date)->where('schedule_time', $value->schedule_time)->where('booking_id', '!=', $value->booking_id)->count();
                        $bookingSchedule = Booking::Where('schedule_date', $value->schedule_date)->where('schedule_time', $value->schedule_time)->where('booking_id', '!=', $value->booking_id)->get();
                        $cleaner_data = User::Where('user_type', 'Cleaner')->Where('account_status', 'Validated')->get();
                        $cleanerCount = Assigned_cleaner::Where('booking_id', $value->booking_id)->count();
                        $acceptedCount = Assigned_cleaner::Where('booking_id', $value->booking_id)->where('status', 'Accepted')->count();
                        ?>
                        @if($acceptedCount == 0)
                        <?php $total = $total; ?>
                        @else
                        <?php $total = $total - $acceptedCount; ?>
                        @endif
                        @while($total > 0)
                        <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                        <input type="hidden" name="status" value="Pending">
                        <label for="cleaner">Cleaner: </label>
                        <select name="cleaner_id[]" id="cleaner" class="form-control" style="width: 100% !important; max-height: 30px; overflow-y: auto; z-index:999999 !important;">
                            @if( $cleaner_data == null)
                            <option value="">No Validated Cleaner</option>
                            @endif
                            @if($cleanerCount == 0)
                            <!-- Booking does not exist in Assign Table -->
                            @if($cleanerSchedule == 0)
                            <!-- Check if the booking have the no same Schedule -->
                            @if($cleaner_data != null)
                            <!-- Check if Validated Cleaner exist-->
                            @foreach($cleaner_data as $key => $cleaner)
                            <?php
                            $fullname = User::Where('user_id', $cleaner->user_id)->value('full_name');
                            ?>
                            <option value="{{  $cleaner->user_id }}">{{ $fullname }}</option>
                            @endforeach
                            @endif
                            @else
                            <!-- Booking has the same Schedule -->
                            <?php
                            $items = array();
                            $count = 0;
                            $itemExist = array();
                            $counter = 0;
                            ?>
                            @if($cleaner_data != null)
                            <!-- Check if Validated Cleaner exist-->
                            @foreach($bookingSchedule as $key => $cleanerWithSchedule)
                            <?php
                            $cleanerID = Assigned_cleaner::Where('booking_id', $cleanerWithSchedule->booking_id)->get();
                            ?>
                            @if($cleanerID != null)
                            <!-- Check if booking already have a cleaner-->
                            @foreach($cleaner_data as $key => $cleaner)
                            @foreach($cleanerID as $key => $assignCleaner)
                            <?php
                            $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id)->value('user_id');
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
                            $final = array_diff($items, $itemExist);
                            ?>
                            @if($final != null)
                            @foreach($final as $userID)
                            <?php
                            $fullname = User::Where('user_id', $userID)->value('full_name');
                            ?>
                            <option value="{{  $userID }}">{{ $fullname }}</option>
                            @endforeach
                            @else
                            <option value="">No Cleaner</option>
                            @endif
                            @endif
                            @endif
                            @else
                            <?php
                            $items = array();
                            $count = 0;

                            ?>
                            @if($cleanerSchedule == 0)
                            <!-- Check if the booking have the no same Schedule -->
                            @if($cleaner_data != null)
                            <!-- Check if Validated Cleaner exist-->
                            <?php
                            $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', 'Accepted')->orWhere('status', 'Declined')->orWhere('status', 'Pending')->get();

                            ?>

                            @foreach($cleaner_data as $key => $cleaner)
                            @foreach($cleanerID as $key => $assignCleaner)
                            <?php
                            $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id)->value('user_id');
                            ?>
                            @if($cleaner->user_id != $assignUser)
                            <?php $items[$count++] =  $cleaner->user_id; ?>
                            @else
                            @break
                            @endif
                            @endforeach
                            @endforeach
                            \ <?php
                                $items = array_unique($items);
                                ?>
                            @if($items != null)
                            @foreach($items as $userID)
                            <?php
                            $fullname = User::Where('user_id', $userID)->value('full_name');
                            ?>
                            <option value="{{  $userID }}">{{ $fullname }}</option>
                            @endforeach
                            @else
                            <option value="">No Cleaner</option>
                            @endif

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
                            @if($cleanerID != null)
                            <!-- Check if booking already have a cleaner-->
                            @foreach($cleaner_data as $key => $cleaner)
                            @foreach($cleanerID as $key => $assignCleaner)
                            <?php
                            $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id)->value('user_id');
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
                            $final = array_diff($items, $itemExist);
                            ?>
                            @if($final != null)
                            @foreach($final as $userID)
                            <?php
                            $fullname = User::Where('user_id', $userID)->value('full_name');
                            ?>
                            <option value="{{  $userID }}">{{ $fullname }}</option>
                            @endforeach
                            @else
                            <option value="">No Cleaner</option>
                            @endif
                            @endif
                            @endif
                            @endif
                        </select> <br>
                        <?php
                        $total--;
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
    <div class="modal fade" id="decline-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Decline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateStatus') }}" method="post">
                        @if(Session::get('success-decline'))
                        <script>
                            swal({
                                title: "Successfully Declined Transaction!",
                                icon: "success",
                                button: "Close",
                            });
                        </script>
                        @endif

                        @if(Session::get('fail'))
                        <script>
                            swal({
                                title: "Something went wrong, try again!",
                                icon: "error",
                                button: "Close",
                            });
                        </script>
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
    </div><!-- End of Modal -->

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
            var admin_transaction = parseInt($('#admin').find('.admin_transaction').html());
            if (admin_transaction) {
                $('#admin').find('.admin_transaction').html(admin_transaction + 1);
            } else {
                $('#admin').find('.admin_transaction').html(admin_transaction + 1);
            }
            $('#refresh').load(window.location.href + " #refresh");
            $('#status').load(window.location.href + " #status");
        });
    </script>

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
    @if(Session::has('success-decline'))
    <script>
        swal({
            title: "Successfully Declined Transaction!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif

    @if(Session::has('success'))
    <script>
        swal({
            title: "Transaction Status Updated Successfully!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    @if(session('fail'))
    <script>
        swal({
            title: "Something went wrong, try again!",
            icon: "error",
            button: "Close",
        });
    </script>
    @endif

    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>
@endsection