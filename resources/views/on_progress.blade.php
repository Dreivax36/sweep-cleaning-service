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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">
    
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
                    <a href="admin_dashboard" class="nav-link">
                        Home
                    </a>
                    <a class="nav-link" href="admin_services" role="button">
                        Services
                    </a>
                    <a class="nav-link" href="admin_transaction" role="button" id="active">
                        Transactions
                    </a>
                    <a class="nav-link" href="admin_user" role="button">
                        User
                    </a>
                    <a class="nav-link" href="admin_payroll" role="button">
                        Payroll
                    </a>
                    <a class="nav-link" href="admin_reports" role="button">
                        Reports
                    </a>
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

<body>
    <?php
        $booking_data = Booking::Where('status', 'In-Progress')->orderBy('updated_at', 'DESC')->get();
        $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'In-Progress')->orWhere('status', 'On-the-Way')->orWhere('status', 'No-Available-Cleaner')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
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
                $onprogressSub = Booking::where('status', 'In-Progress')->count();
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
            <a class="user_type_btn" href="accepted">
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
            <a class="user_type_btn" id="active" href="on_progress">
                IN-PROGRESS
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

    <div class="row row_transaction justify-content-center" id="status">
        @if($booking_data != null )
        @foreach($booking_data as $key => $value)
        <?php
            $service_data = Service::Where('service_id', $value->service_id)->get();
            $customerid = $value->customer_id;
            $userId = Customer::Where('customer_id', $customerid)->value('user_id');
            $user_data = User::Where('user_id', $userId)->get();
            $address = Address::Where('customer_id', $customerid)->value('address');
        ?>
        <div class="card card_transaction mb-3" style="width: 25rem;" >
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
                        $statusOnProgress = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "In-Progress")->count();
                        $statusdone = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Done")->count();
                        $reviews = Review::Where('booking_id', '=', $value->booking_id)->count();
                    ?>
                    
                    @if($value->status == "In-Progress" && $statusdone == $price_data->number_of_cleaner)
                    <button class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Done">
                        CLEANING DONE
                    </button>
                    @endif
                    
                </div>
                </form>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>

    @endforeach
    @endforeach
    @else
    <div class="banner-container">
        <div class="banner">
            <div class="text">
                <h1> 
                    Currently no transaction.
                </h1>
            </div>
            <div class="image">
                <img src="/images/services/header_img.png" class="img-fluid">
            </div>
        </div>
    </div>
    @endif
    </div>
 
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('21a2d0c6b21f78cd3195', {
            cluster: 'ap1'
        });
        var pos = "";
        if (window.innerWidth > 801) {
            pos = 'top-end';
        } else {
            pos = 'top';
        }

        const Toast = Swal.mixin({
            toast: true,
            position: pos,
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {
            var result = data.messages;
            var admin_transaction = parseInt($('#admin').find('.on_progress').html());
            if (admin_transaction) {
                $('#admin').find('.on_progress').html(admin_transaction + 1);
            } else {
                $('#admin').find('.on_progress').html(admin_transaction + 1);
            }
            $('#refresh').load(window.location.href + " #refresh");
            $('#status').load(window.location.href + " #status");
            
            Toast.fire({
                    animation: true,
                    icon: 'success',
                    title: JSON.stringify(result),
                })
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        No
                    </button>
                    <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">
                        Yes
                    </button>
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
</body>
@endsection