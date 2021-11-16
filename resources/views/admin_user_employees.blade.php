<?php

use App\Models\User;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Cleaner;
use App\Models\Identification;
use App\Models\Notification;
?>
@extends('head_extention_admin')

@section('content')
<title>
    Admin Employees Page
</title>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
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

    <?php
    $user_data = User::all();
    $user_count = User::all()->count();
    $customer_count = User::Where('user_type', '=', 'Customer')->count();
    $cleaner_count = User::Where('user_type', '=', 'Cleaner')->count();
    $employee_count = Employee::all()->count();
    ?>

    <div class="row head">
        <div class="col-md-8">
            <div>
                <!-- Sub Header -->
                <a class="user_type_btn_cleaner " href="admin_user">
                    ALL
                    <p class="total_value">
                        ({{ $user_count }})
                    </p>
                </a>
                <a class="user_type_btn_cleaner" href="admin_user_customer">
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
                <a class="user_type_btn_cleaner active_sub" href="admin_user_employees">
                    EMPLOYEES
                    <p class="total_value">
                        ({{ $employee_count }})
                    </p>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-block btn-primary add_service_btn float-right" data-toggle="modal" data-target="#addEmployee">
                + Add Employee
            </button>
        </div>
    </div>

    <div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content service_modal_content">
                <div class="modal-header customer_services_modal_header">
                    <div>
                        <h4 class="modal_customer_services_title modal-title">
                            <b> Add New Employee</b>
                        </h4>
                    </div>
                    <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding services -->
                    <form action="{{ route('addEmployee') }}" method="post" id="myform">
                        @if(Session::get('success'))
                        <script>
                            swal({
                                title: "Employee added successfully!",
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
                        <div class="form-group">
                            <label class="upload_label">
                                Employee Code:
                            </label>
                            <input type="text" required class="form-control w-100 add_service_form" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" required>
                            <span class="text-danger">@error('employee_code'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label class="upload_label">
                                Employee Name:
                            </label>
                            <input type="text" required class="form-control w-100 add_service_form" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            <span class="text-danger">@error('full_name'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label class="upload_label">
                                Email Address:
                            </label>
                            <input type="text" required class="form-control w-100 add_service_form" id="email" name="email" value="{{ old('email') }}" required>
                            <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label class="upload_label">
                                Contact Number:
                            </label>
                            <input type="text" required class="form-control w-100 add_service_form" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                            <span class="text-danger">@error('contact_number'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label class="upload_label">
                                Department:
                            </label>
                            <select name="department" class="form-control w-100 add_service_form" aria-label="Default select example" required>
                                <option selected>Select Department</option>
                                <option value="Human Resource Department">Human Resource Department</option>
                                <option value="Operations Department">Operations Department</option>
                                <option value="Marketing Department">Marketing Department</option>
                                <option value="IT Department">IT Department</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="upload_label">
                                Position:
                            </label>
                            <select name="position" class="form-control w-100 add_service_form" aria-label="Default select example" required>
                                <option selected>Select Position</option>
                                <option value="Manager">Manager</option>
                                <option value="Employee">Employee</option>
                                <option value="Customer Representative">Customer Representative</option>
                                <option value="Quality Assurance Head">Quality Assurance Head</option>
                                <option value="IT Project Head">IT Project Head</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer service_modal_header">
                    <button type="submit" class="btn btn-primary update_btn">
                        ADD
                    </button>
                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                        CANCEL
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Add Service -->

    <div class="user_table_con">
        <!-- Cleaner Tabler -->
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead class="head_user">
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            Employee Code
                        </th>
                        <th class="text-center user_table_header">
                            Full Name
                        </th>
                        <th class="text-center user_table_header">
                            Email Address
                        </th>
                        <th class="text-center user_table_header">
                            Contact Number
                        </th>
                        <th class="text-center user_table_header">
                            Birthday
                        </th>
                        <th class="text-center user_table_header">
                            Department
                        </th>
                        <th class="text-center user_table_header">
                            Position
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $employee = Employee::all();
                    ?>
                    @foreach($employee as $value)
                    <tr class="user_table_row">
                        <td class="user_table_data">
                            {{ $value->employee_code }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->full_name }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->email }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->contact_number }}
                        </td>
                        <td class="user_table_data">
                            {{ date('F d, Y', strtotime($value->birthday)) }}
                        </td> 
                        <td class="user_table_data">
                            {{ $value->department }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->position }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- End of Cleaner Table -->
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

        var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {

            var result = data.messages;
            var pending = parseInt($('#admin').find('.pending').html());
            if (pending) {
                $('#admin').find('.pending').html(pending + 1);
            } else {
                $('#admin').find('.pending').html(pending + 1);
            }
            $('#refresh').load(window.location.href + " #refresh");
        });
    </script>
    <!-- Scripts -->
    @if(Session::has('success'))
    <script>
        swal({
            title: "Employee added successfully",
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
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>
@endsection