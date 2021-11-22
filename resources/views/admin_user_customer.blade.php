<?php

use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Identification;
use App\Models\Notification;
use App\Models\Employee;
?>
@extends('head_extention_admin')

@section('content')
<title>
    Admin Customer Page
</title>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
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
                    <a href="admin_dashboard" class="nav-link">Home</a>
                    <a class="nav-link" href="admin_services" role="button">Services</a>
                    <a class="nav-link" href="admin_transaction" role="button">Transactions</a>
                    <a class="nav-link" href="admin_user" role="button" id="active">User</a>
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
                            <span class="badge alert-danger pending">{{$notifCount}}</span>
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
    <div class="body-container">
        <?php
        $user_data = User::all();
        $user_count = User::all()->count();
        $customer_count = User::Where('user_type', '=', 'Customer')->count();
        $cleaner_count = User::Where('user_type', '=', 'Cleaner')->count();
        $employee_count = Employee::all()->count();
        ?>
        <div class="row user_btn_con">
            <!-- Sub Header -->
            <a class="user_type_btn_cleaner " href="admin_user">
                ALL
                <p class="total_value">
                    ({{ $user_count }})
                </p>
            </a>
            <a class="user_type_btn_cleaner active_sub" href="admin_user_customer">
                CUSTOMER
                <p class="total_value">
                    ({{ $customer_count }})
                </p>
            </a>
            <a class="user_type_btn_cleaner" href="admin_user_cleaner">
                CLEANER
                <p class="total_value">
                    ({{ $cleaner_count }})
                </p>
            </a>
            <a class="user_type_btn_cleaner" href="admin_user_employees">
                EMPLOYEES
                <p class="total_value">
                    ({{ $employee_count }})
                </p>
            </a>
        </div>

        <div class="user_table_con">
            <!-- Customer Table -->
            <div class="table_detail_con">
                <table class="table user_table" id="user_table">
                    <thead class="head_user">
                        <tr class="user_table_row">
                            <th class="text-center user_table_header">
                                Full Name
                            </th>
                            <th class="text-center user_table_header">
                                Address
                            </th>
                            <th class="text-center user_table_header">
                                Email Address
                            </th>
                            <th class="text-center user_table_header">
                                Contact Number
                            </th>
                            <th class="text-center user_table_header">
                                Valid ID
                            </th>
                            <th class="text-center user_table_header">
                                Account Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_data = User::Where('user_type', 'Customer')->where('email_verified_at', '!=', null)->orderBy('updated_at', 'DESC')->get();
                        ?>
                        @foreach($user_data as $key => $value)

                        <?php
                        $customer_id = Customer::Where('user_id', $value->user_id)->value('customer_id');
                        $address_data = Address::Where('customer_id', $customer_id)->get();
                        $valid_id = Identification::Where('user_id', $value->user_id)->value('valid_id');
                        ?>
                        @foreach($address_data as $key => $data)


                        <tr class="user_table_row">
                            <td class="user_table_data">
                                {{ $value->full_name }}
                            </td>
                            <td class="user_table_data">
                                {{ $data->address }}
                            </td>
                            <td class="user_table_data">
                                {{ $value->email }}
                            </td>
                            <td class="user_table_data">
                                {{ $value->contact_number }}
                            </td>
                            <td class="user_table_data">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter-{{ $value->user_id }}">
                                    view
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter-{{ $value->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Valid ID</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card admin_profile_avatar_con">
                                                    <img class="card-img-top profile_avatar_img" src="{{asset('/images/'.$valid_id ) }}" alt="profile_picture" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="user_table_data">
                                @if($value->account_status == "To_validate")
                                <div class="verify_con">
                                    <button class="btn btn-success" onclick="document.location='{{ route('update_account', $value->user_id) }}'">
                                        VALIDATE
                                    </button>
                                </div>
                                @else
                                {{ $value->account_status }}
                                @endif
                            </td>
                        </tr>

                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- End of Customer Table -->
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

        <!-- Datatables Scripts -->
        <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

        <!-- Datatable -->
        <script>
            $(document).ready(function() {
                $('#user_table').DataTable();
            });
        </script>
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
                Toast.fire({
                    animation: true,
                    icon: 'success',
                    title: JSON.stringify(result),
                })
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
        <!-- Scripts -->

        @if(session('success'))
        <script>
            swal({
                title: "Customer account successfully approved!",
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
    </div>
</body>
@endsection