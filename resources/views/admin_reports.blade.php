<?php

use App\Models\Booking;
use App\Models\Service;
use App\Models\Price;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Cleaner_review;
use App\Models\Assigned_cleaner;
use App\Models\Notification;
use App\Models\Payment;
?>
@extends('head_extention_admin')

@section('content')
<title>
    Admin Payroll Cleaner Page
</title>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_reports.css')}}">

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
                    <a class="nav-link" href="admin_user" role="button">User</a>
                    <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
                    <a class="nav-link" href="admin_reports" role="button" id="active">Reports</a>
                    <!-- Notification -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <div class="row user_btn_con1">
        <!-- Sub Header -->
        <a class="user_type_btn_cleaner" style="font-size:25px; color: #FFB703; margin-top:50px; margin-left:85px;">
            REPORTS
        </a>
    </div>
    <?php
        $mytime = Carbon\Carbon::now();
    ?>
    <div class="row justify-content-center" id="status">
        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Average Monthly Income
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <?php
                $payments = Payment::selectRaw('extract(month from created_at) as month, sum(amount) * .30 as amount')
                ->groupBy('month')
                ->orderByRaw('min(created_at) desc')
                ->get();
            ?>
            <div class="row no-gutters">
                <div class="card-body">
                    <div class="justify-content-center" style="height: 15rem; align-items:center; text-align: center;">
                        <canvas id="avgWeeklyIncome"></canvas>
                        <script>
                            const ctx = document.getElementById('avgWeeklyIncome').getContext('2d');
                            const myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: [ 'September',
                                            @foreach($payments as $payment)
                                                '{{date("F", mktime(0, 0, 0, $payment->month, 1))}}',
                                            @endforeach
                                        ],
                                    datasets: [{
                                        label: 'Sweep Monthly Income',
                                        data: [ 0,
                                            @foreach($payments as $payment)
                                                '{{$payment->amount}}',
                                            @endforeach
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-income">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for details -->
        <div class="modal fade" id="details-income" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Average Monthly Income
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Month
                                            </th>
                                            <td scope="row" class="user_table_data">
                                                Income
                                            </td>
                                        </tr>
                                        @foreach($payments as $payment)
                                        <tr class="user_table_row">
                                            <th class="user_table_header">
                                                {{date("F", mktime(0, 0, 0, $payment->month, 1))}}
                                            </th>
                                            <td class="user_table_data">
                                            ₱ {{ number_format((float)$payment->amount, 2, '.', '')}}
                                            </td>
                                        </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            $customerCount = Booking::selectRaw('extract(month from created_at) as month, customer_id, count(customer_id) as customer')
                ->groupBy('month', 'customer_id')
                ->orderByRaw('min(created_at) desc')
                ->get();
        ?>
        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Average Customers Per Month
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="card-body">


                    <div class="justify-content-center" style="height: 15rem; align-items:center; text-align: center;">
                        <canvas id="avgWeeklyCust"></canvas>
                        <script>
                            const ctx1 = document.getElementById('avgWeeklyCust').getContext('2d');
                            const myChart1 = new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: ['September',
                                            @foreach($customerCount as $customer)
                                                '{{date("F", mktime(0, 0, 0, $customer->month, 1))}}',
                                            @endforeach
                                        ],
                                    datasets: [{
                                        label: 'Monthly Number of Customers',
                                        data: [0,
                                            @foreach($customerCount as $customer)
                                                '{{$customer->customer}}',
                                            @endforeach
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-customer">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for details -->
    <div class="modal fade" id="details-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Average Customers Per Month
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Month
                                            </th>
                                            <td scope="row" class="user_table_data">
                                                Customer
                                            </td>
                                        </tr>
                                        @foreach($customerCount as $customer)
                                        <tr class="user_table_row">
                                            <th class="user_table_header">
                                                {{date("F", mktime(0, 0, 0, $customer->month, 1))}}
                                            </th>
                                            <td class="user_table_data">
                                                {{$customer->customer}}
                                            </td>
                                        </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        $serviceName = Service::orderBy('service_id', 'DESC')->get();  
    ?>
    <div class="row justify-content-center" id="status">
        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Revenue per Service
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="card-body">
                    <div class="justify-content-center" style="height: 15rem; align-items:center; text-align: center;">
                        <canvas id="avgWeeklyIncome"></canvas>
                        <script>
                            const ctx = document.getElementById('avgWeeklyIncome').getContext('2d');
                            const myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [
                                        @foreach($serviceName as $name)
                                            '{{$name->service_name}}',
                                        @endforeach
                                    ],
                                    
                                    datasets: [{
                                        label: 'Revenue per Service',
                                        data: [
                                            @foreach($serviceName as $id)
                                            <?php
                                                $serviceRevenue = 0;
                                                $bookingID = Booking::where('service_id', $id->service_id)->where('status', 'Completed')->get();
                                                    foreach($bookingID as $booking){
                                                        $price = Price::where('service_id', $id->service_id)->where('property_type', $booking->property_type)->value('price');
                                                        $serviceRevenue = $serviceRevenue + $price;
                                                    }  
                                            ?>
                                            '{{$serviceRevenue}}',
                                            @endforeach
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-revenue">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for details -->
        <div class="modal fade" id="details-revenue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Revenue per Service
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Service
                                            </th>
                                            <td scope="row" class="user_table_data">
                                                Revenue
                                            </td>
                                        </tr>
                                        @foreach($serviceName as $serviceName)
                                        <tr class="user_table_row">
                                            <th class="user_table_header">
                                                {{$serviceName->service_name}}
                                            </th>
                                            <td class="user_table_data">
                                            @foreach($serviceName as $id)
                                            <?php
                                                $serviceRevenue = 0;
                                                $bookingID = Booking::where('service_id', $serviceName->service_id)->where('status', 'Completed')->get();
                                                    foreach($bookingID as $booking){
                                                        $price = Price::where('service_id', $serviceName->service_id)->where('property_type', $booking->property_type)->value('price');
                                                        $serviceRevenue = $serviceRevenue + $price;
                                                    }  
                                            ?>
                                            {{$serviceRevenue}}
                                            @endforeach
                                            </td>
                                        </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="card  mb-3" style="width: 30rem; height: 39rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Most Requested Service
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <?php
                $service = Service::orderBy('service_id', 'DESC')->get();  
                $totalRequested = Booking::where('status', '!=', 'Cancelled')->count();
            ?>
            <div class="row no-gutters">
                <div class="card-body">
                    <div class="justify-content-center">
                        <canvas id="mostRequestedService"></canvas>
                        <script>
                            const ctx3 = document.getElementById('mostRequestedService').getContext('2d');
                            const myChart3 = new Chart(ctx3, {
                                type: 'pie',
                                data: {
                                    labels: [
                                        @foreach($service as $name)
                                            '{{$name->service_name}}',
                                        @endforeach
                                    ],
                                    datasets: [{
                                        label: 'Weekly Number of Customers',
                                        data: [
                                                @foreach($service as $id)
                                                    <?php
                                                        $requested = Booking::where('service_id', $id->service_id)->where('status', '!=', 'Cancelled')->count();
                                                        $serviceRequested = ($requested / $totalRequested) * .100;
                                                    ?>
                                                    '{{$serviceRequested}}',
                                                @endforeach
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-requested">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
           <!-- Modal for details -->
           <div class="modal fade" id="details-requested" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Most Requested Service
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Service
                                            </th>
                                            <td scope="row" class="user_table_data">
                                                Requested
                                            </td>
                                        </tr>
                                        @foreach($service as $serviceNames)
                                        <tr class="user_table_row">
                                            <th class="user_table_header">
                                                {{$serviceNames->service_name}}
                                            </th>
                                            <td class="user_table_data">
                                            <?php
                                                $requested = Booking::where('service_id', $serviceNames->service_id)->where('status', '!=', 'Cancelled')->count();
                                                $serviceRequested = ($requested / $totalRequested) * .100;
                                            ?>
                                                '{{$serviceRequested}}',
                                            </td>
                                        </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <div class="card  mb-3" style="width: 30rem; height: 39rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Ratio of Completed Jobs and Cancelled Jobs
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="card-body">
                    <?php
                        $completed = Booking::where('status', 'Completed')->count();
                        $cancelled = Booking::where('status', 'Cancelled')->count();
                        $totalBook = $completed + $cancelled;
                    ?>
                    <div class="justify-content-center">
                        <canvas id="ratio"></canvas>
                        <script>
                            var completed = <?php echo ($completed / $total) * .100; ?>;
                            var cancelled = <?php echo ($cancelled / $total) * .100; ?>;
                            const ctx4 = document.getElementById('ratio').getContext('2d');
                            const myChart4 = new Chart(ctx4, {
                                type: 'pie',
                                data: {
                                    labels: ['Cancelled', 'Completed'],
                                    datasets: [{
                                        label: 'Cancellation Rate vs Completion Rate',
                                        data: [cancelled, completed],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',

                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',

                                        ],
                                        borderWidth: 1
                                    }]
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-employees">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" id="status2">


        <!-- Count active transaction and completed, declined, and cancelled transaction -->
        <!-- Display when no transaction -->
        <!-- Get transaction details -->
        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Top Performing Cleaners
                    </h3>
                </div>
                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="card-body">
                    <?php
                        $cleaner = Cleaner_review::selectRaw('cleaner_id, avg(rate) as rate')
                        ->groupBy('cleaner_id')
                        ->orderBy('rate')
                        ->get();

                        $counter = 1;
                    ?>
                    <table class="table table-striped user_info_table">
                        <tbody>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Rank
                                </th>
                                <td class="user_table_data">
                                    Name
                                </td>
                                <td class="user_table_data">
                                    Ratings
                                </td>
                                <td class="user_table_data">
                                    Jobs Completed
                                </td>
                                <td class="user_table_data">
                                    Jobs Cancelled
                                </td>
                            </tr>
                            @foreach($cleaner as $cleaners)
                                <?php 
                                    $cleaner_id = $cleaners->cleaner_id;
                                    $cleanerID = Cleaner::where('cleaner_id', $cleaner_id)->value('user_id');
                                    $users = User::where('user_id', $cleanerID)->value('full_name');
                                    $cancel = Assigned_cleaner::where('cleaner_id', $cleaner_id)->where('status', 'Cancelled')->count();
                                    $complete = Assigned_cleaner::where('cleaner_id', $cleaner_id)->where('status', 'Completed')->count();
                                ?>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Top {{$counter++}}
                                </th>
                                <td class="user_table_data">
                                    {{$users}}
                                </td>
                                <td class="user_table_data">
                                {{number_format((float)$cleaners->rate, 0, '.', '')}}/5 Stars
                                </td>
                                <td class="user_table_data">
                                    {{$complete}} Jobs
                                </td>
                                <td class="user_table_data">
                                    {{$cancel}} Jobs
                                </td>
                            </tr>
                                @if($counter == 3)
                                    @break
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Check if the customer already review booking -->

                </div>

            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-topCleaner">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
            <!-- Modal for details -->
            <div class="modal fade" id="details-topCleaner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Top Performing Cleaners
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Rank
                                            </th>
                                            <td class="user_table_data">
                                                Name
                                            </td>
                                            <td class="user_table_data">
                                                Ratings
                                            </td>
                                            <td class="user_table_data">
                                                Jobs Completed
                                            </td>
                                            <td class="user_table_data">
                                                Jobs Cancelled
                                            </td>
                                        </tr>
                                        <?php
                                            $count = 1;
                                        ?>
                                        @foreach($cleaner as $cleaners)
                                            <?php 
                                                $cleaner_id = $cleaners->cleaner_id;
                                                $cleanerID = Cleaner::where('cleaner_id', $cleaner_id)->value('user_id');
                                                $users = User::where('user_id', $cleanerID)->value('full_name');
                                                $cancel = Assigned_cleaner::where('cleaner_id', $cleaner_id)->where('status', 'Cancelled')->count();
                                                $complete = Assigned_cleaner::where('cleaner_id', $cleaner_id)->where('status', 'Completed')->count();
                                            ?>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top {{$count++}}
                                            </th>
                                            <td class="user_table_data">
                                                {{$users}}
                                            </td>
                                            <td class="user_table_data">
                                            {{number_format((float)$cleaners->rate, 0, '.', '')}}/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                {{$complete}} Jobs
                                            </td>
                                            <td class="user_table_data">
                                                {{$cancel}} Jobs
                                            </td>
                                        </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

        ?>
        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Top Performing Employees
                    </h3>
                </div>
                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                    </h6>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="card-body">

                    <table class="table table-striped user_info_table">
                        <tbody>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Rank
                                </th>
                                <td class="user_table_data">
                                    Name
                                </td>
                                <td class="user_table_data">
                                    Ratings
                                </td>
                                <td class="user_table_data">
                                    Jobs Completed
                                </td>
                                <td class="user_table_data">
                                    Jobs Cancelled
                                </td>
                            </tr>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Top 1
                                </th>
                                <td class="user_table_data">
                                    Juan Pedro Dela Cruz
                                </td>
                                <td class="user_table_data">
                                    4.3/5 Stars
                                </td>
                                <td class="user_table_data">
                                    14 Jobs
                                </td>
                                <td class="user_table_data">
                                    2 Jobs
                                </td>
                            </tr>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Top 2
                                </th>
                                <td class="user_table_data">
                                    Juan Pedro Dela Cruz
                                </td>
                                <td class="user_table_data">
                                    4.2/5 Stars
                                </td>
                                <td class="user_table_data">
                                    11 Jobs
                                </td>
                                <td class="user_table_data">
                                    1 Jobs
                                </td>
                            </tr>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Top 3
                                </th>
                                <td class="user_table_data">
                                    Juan Pedro Dela Cruz
                                </td>
                                <td class="user_table_data">
                                    4.2/5 Stars
                                </td>
                                <td class="user_table_data">
                                    14 Jobs
                                </td>
                                <td class="user_table_data">
                                    4 Jobs
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Check if the customer already review booking -->
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-employees">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for details -->
            <div class="modal fade" id="details-employees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Top Performing Employees
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ date('F d, Y', strtotime($mytime->toDateTimeString()))}}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Rank
                                            </th>
                                            <td class="user_table_data">
                                                Name
                                            </td>
                                            <td class="user_table_data">
                                                Ratings
                                            </td>
                                            <td class="user_table_data">
                                                Jobs Completed
                                            </td>
                                            <td class="user_table_data">
                                                Jobs Cancelled
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 1
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.3/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                2 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 2
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                11 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                1 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 3
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 4
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 5
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 6
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 7
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 8
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top 9
                                            </th>
                                            <td class="user_table_data">
                                                Juan Pedro Dela Cruz
                                            </td>
                                            <td class="user_table_data">
                                                4.2/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                                14 Jobs
                                            </td>
                                            <td class="user_table_data">
                                                4 Jobs
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-9">
                                Generate Report
                            </button>
                        </div>
                    </div>
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
                        Are you sure you want to Logout?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">Yes</button>
                </div>
            </div>
        </div>
    </div>

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

        // Enable pusher logging 
        Pusher.logToConsole = true;

        var pusher = new Pusher('21a2d0c6b21f78cd3195', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {
            var result = data.messages;
            var pending = parseInt($('#admin').find('.pending').html());
            //Trigger and add notification badge
            if (pending) {
                $('#admin').find('.pending').html(pending + 1);
            } else {
                $('#admin').find('.pending').html(pending + 1);
            }
            //Reload Notification
            $('#refresh').load(window.location.href + " #refresh");
        });
    </script>

    <!-- Footer -->
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>
@endsection