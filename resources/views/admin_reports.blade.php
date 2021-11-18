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
    use App\Models\Salary;

?>
@extends('head_extention_admin')

@section('content')
<title>
    Admin Reports Page
</title>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_reports.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">
<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
</head>
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
                            <h4 class="notif">Notifications</h4>
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
   
    <div class="row user_btn_con1">
        <!-- Sub Header -->
        <a class="user_type_btn_cleaner" style="font-size:25px; color: #FFB703; margin-top:50px; margin-left:85px;">
            REPORTS
        </a>
    </div>
    <?php
    $mytime = Carbon\Carbon::now();
    ?>
    <?php
    $serviceName = Service::orderBy('service_id', 'DESC')->get();
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
                        <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                    </h6>
                </div>
            </div>
            <?php
            $payments = Payment::selectRaw('extract(month from created_at) as month, sum(amount) * .05 as amount')
                ->groupBy('month')
                ->orderByRaw('min(created_at) asc')
                ->get();
            ?>
            <div>
                <div class="card-body">
                    <div class="justify-content-center" style="height: 15rem; align-items:center; text-align: center;">
                        <canvas id="avgWeeklyIncome"></canvas>
                        <script>
                            const bgColor = {
                                id: 'bgColor',
                                beforeDraw: (chart, options) => {
                                    const {
                                        ctx,
                                        width,
                                        height
                                    } = chart;
                                    ctx.fillStyle = 'white';
                                    ctx.fillRect(0, 0, width, height)
                                    ctx.restore();
                                }
                            }
                            const ctx = document.getElementById('avgWeeklyIncome').getContext('2d');
                            const myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['September',
                                        @foreach($payments as $payment)
                                        '{{date("F", mktime(0, 0, 0, $payment->month, 1))}}',
                                        @endforeach
                                    ],
                                    datasets: [{
                                        label: 'Sweep Monthly Income',
                                        data: [0,
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
                                },
                                plugins: [bgColor]
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
                        <button type="button" class="btn btn-primary pay_btn" onclick="avgIncome()">
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
                                <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                            </h6>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="customer_trans_modal_body_1_con">
                            <table class="table table-striped user_info_table" id="user_table">
                                <tbody>
                                    <tr class="user_table_row">
                                        <th scope="row" class="user_table_header">
                                            Month
                                        </th>
                                        <td scope="row" class="user_table_header">
                                            Income
                                        </td>
                                    </tr>
                                    @foreach($payments as $payment)
                                    <tr class="user_table_row">
                                        <th class="user_table_data">
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
                        <button type="button" class="btn btn-primary pay_btn" onclick="avgIncome()">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $customerCount = Booking::selectRaw('extract(month from created_at) as month, count(customer_id) as customer')
            ->groupBy('month')
            ->orderByRaw('min(created_at) asc')
            ->get();
        ?>
        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Average Booking Per Month
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                    </h6>
                </div>
            </div>
            <div>
                <div class="card-body">
                    <div class="justify-content-center" style="height: 15rem; align-items:center; text-align: center;">
                        <canvas id="avgWeeklyCust"></canvas>
                        <script>
                            const bgColor1 = {
                                id: 'bgColor1',
                                beforeDraw: (chart, options) => {
                                    const {
                                        ctx,
                                        width,
                                        height
                                    } = chart;
                                    ctx.fillStyle = 'white';
                                    ctx.fillRect(0, 0, width, height)
                                    ctx.restore();
                                }
                            }

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
                                },
                                plugins: [bgColor1]
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
                        <button type="button" class="btn btn-primary pay_btn" onclick="avgBooking()">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="details-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content customer_trans_modal_content">
                        <div class="modal-header customer_trans_modal_header">
                            <div class="card_body">
                                <h3 class="service_title_trans">
                                    Average Booking Per Month
                                </h3>
                                <h6 class="booking_date">
                                    <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table" id="user_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Month
                                            </th>
                                            <td scope="row" class="user_table_header">
                                                Customer
                                            </td>
                                        </tr>
                                        @foreach($customerCount as $customer)
                                        <tr class="user_table_row">
                                            <th class="user_table_data">
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
                            <button type="button" class="btn btn-primary pay_btn" onclick="avgBooking()">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card  mb-3" style="width: 40rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Revenue per Service
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                    </h6>
                </div>
            </div>
            <div>
                <div class="card-body">
                    <div class="justify-content-center" style="height: 15rem; align-items:center; text-align: center;">
                        <canvas id="avgRevenueperService"></canvas>
                        <script>
                            const bgColor2 = {
                                id: 'bgColor2',
                                beforeDraw: (chart, options) => {
                                    const {
                                        ctx,
                                        width,
                                        height
                                    } = chart;
                                    ctx.fillStyle = 'white';
                                    ctx.fillRect(0, 0, width, height)
                                    ctx.restore();
                                }
                            }

                            const ctx2 = document.getElementById('avgRevenueperService').getContext('2d');
                            const myChart2 = new Chart(ctx2, {
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
                                            foreach ($bookingID as $booking) {
                                                $price = Price::where('service_id', $id->service_id)->where('property_type', $booking->property_type)->value('price');
                                                $serviceRevenue = $serviceRevenue + $price;
                                            }
                                            $serviceRevenue = $serviceRevenue * .05;
                                            ?> '{{$serviceRevenue}}',
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
                                },
                                plugins: [bgColor2]
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
                        <a type="button" class="btn btn-primary pay_btn" onclick="sweepRevenue()">
                            Generate Report
                        </a>
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
                                    <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                                </h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="customer_trans_modal_body_1_con">
                                <table class="table table-striped user_info_table" id="user_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Services
                                            </th>
                                            <td scope="row" class="user_table_header">
                                                Revenue
                                            </td>
                                        </tr>
                                        @foreach($serviceName as $name)
                                        <tr class="user_table_row">
                                            <th class="user_table_data">
                                                {{$name->service_name}}
                                            </th>
                                            <td class="user_table_data">
                                                <?php
                                                $serviceRevenue = 0;
                                                $bookingID = Booking::where('service_id', $name->service_id)->where('status', 'Completed')->get();
                                                foreach ($bookingID as $booking) {
                                                    $price = Price::where('service_id', $name->service_id)->where('property_type', $booking->property_type)->value('price');
                                                    $serviceRevenue = $serviceRevenue + $price;
                                                }
                                                $serviceRevenue = $serviceRevenue * .05;
                                                ?>
                                                ₱ {{ number_format((float)$serviceRevenue, 2, '.', '')}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" onclick="sweepRevenue()">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for details -->
    <?php
    $serviceName = Service::orderBy('service_id', 'DESC')->get();
    ?>

    <div class="row justify-content-center" id="status">
        <div class="card  mb-3" style="width: 30rem; height: 39rem;">
            <div class="card-header">
                <div class="card_body">
                    <h3 class="service_title_trans">
                        Most Requested Service
                    </h3>
                </div>

                <div>
                    <h6 class="booking_date">
                        <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                    </h6>
                </div>
            </div>
            <?php
            $service = Service::orderBy('service_id', 'DESC')->get();
            $totalRequested = Booking::where('status', '!=', 'Cancelled')->count();
            ?>
            <div>
                <div class="card-body">
                    <div class="justify-content-center">
                        <canvas id="mostRequestedService"></canvas>
                        <script>
                            const bgColor3 = {
                                id: 'bgColor3',
                                beforeDraw: (chart, options) => {
                                    const {
                                        ctx,
                                        width,
                                        height
                                    } = chart;
                                    ctx.fillStyle = 'white';
                                    ctx.fillRect(0, 0, width, height)
                                    ctx.restore();
                                }
                            }

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
                                            $serviceRequested = ($requested / $totalRequested) * 100;
                                            ?> '{{$serviceRequested}}',
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
                                },
                                plugins: [bgColor3]
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
                        <button type="button" class="btn btn-primary pay_btn" onclick="requestedService()">
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
                                <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                            </h6>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="customer_trans_modal_body_1_con">
                            <table class="table table-striped user_info_table" id="user_table">
                                <tbody>
                                    <tr class="user_table_row">
                                        <th scope="row" class="user_table_header">
                                            Service
                                        </th>
                                        <td scope="row" class="user_table_header">
                                            Requested
                                        </td>
                                    </tr>
                                    @foreach($service as $serviceNames)
                                    <tr class="user_table_row">
                                        <th class="user_table_data">
                                            {{$serviceNames->service_name}}
                                        </th>
                                        <td class="user_table_data">
                                            <?php
                                            $requested = Booking::where('service_id', $serviceNames->service_id)->where('status', '!=', 'Cancelled')->count();
                                            $serviceRequested = ($requested / $totalRequested) * 100;
                                            ?>
                                            {{ number_format((float)$serviceRequested, 2, '.', '')}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer customer_trans_modal_footer">
                        <button type="button" class="btn btn-primary pay_btn" onclick="requestedService()">
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
                        <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                    </h6>
                </div>
            </div>
            <div>
                <div class="card-body">
                    <?php
                    $completed = Booking::where('status', 'Completed')->count();
                    $cancelled = Booking::where('status', 'Cancelled')->count();
                    $totalBook = $completed + $cancelled;
                    $completed = ($completed / $totalBook) * 100;
                    $cancelled = ($cancelled / $totalBook) * 100;
                    ?>
                    <div class="justify-content-center">
                        <canvas id="ratio"></canvas>
                        <script>
                            const bgColor4 = {
                                id: 'bgColor4',
                                beforeDraw: (chart, options) => {
                                    const {
                                        ctx,
                                        width,
                                        height
                                    } = chart;
                                    ctx.fillStyle = 'white';
                                    ctx.fillRect(0, 0, width, height)
                                    ctx.restore();
                                }
                            }
                            var completed = <?php echo $completed; ?>;
                            var cancelled = <?php echo $cancelled; ?>;
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
                                },
                                plugins: [bgColor4]
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="buttons">
                    <div class="byt float-right">
                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-ratio">
                            DETAILS
                        </button>
                        <button type="button" class="btn btn-primary pay_btn" onclick="completionRatio()">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for details -->
    <div class="modal fade" id="details-ratio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content customer_trans_modal_content">
                <div class="modal-header customer_trans_modal_header">
                    <div class="card_body">
                        <h3 class="service_title_trans">
                            Ratio of Completed Jobs and Cancelled Jobs
                        </h3>
                        <h6 class="booking_date">
                            <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                        </h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="customer_trans_modal_body_1_con">
                        <table class="table table-striped user_info_table" id="user_table">
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Completed
                                    </th>
                                    <td scope="row" class="user_table_header">
                                        Cancelled
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th class="user_table_data">
                                        {{ number_format((float)$completed, 2, '.', '')}} %
                                    </th>
                                    <td class="user_table_data">
                                        {{ number_format((float)$cancelled, 2, '.', '')}} %
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer customer_trans_modal_footer">
                    <button type="button" class="btn btn-primary pay_btn" onclick="completionRatio()">
                        Generate Report
                    </button>
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
                        <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
                    </h6>
                </div>
            </div>
            <div>
                <div class="card-body">
                    <?php
                    $month = $mytime->month;

                    $cleaner = Cleaner_review::selectraw('cleaner_id, avg(rate) as rate')
                            ->whereMonth('created_at', $month)
                            ->groupBy('cleaner_id')
                            ->orderBy('rate','ASC')
                            ->get();

                            $cleanerArray = array();
                            $counter = 0;
                        foreach($cleaner as $cleaners){
                            $cleanerArray[$counter++] = array(
                            "cleaner_id" => $cleaners->cleaner_id,
                            "rate" => $cleaners->rate,
                            "completed" => Assigned_cleaner::where('cleaner_id', $cleaners->cleaner_id)->whereMonth('created_at', $month)->where('status', 'Completed')->count(),
                            "cancelled" => Assigned_cleaner::where('cleaner_id', $cleaners->cleaner_id)->whereMonth('created_at', $month)->where('status', 'Cancelled')->count()
                        );
                        }
                        array_multisort(array_column($cleanerArray, 'completed'),      SORT_DESC,
                                        array_column($cleanerArray, 'rate'), SORT_DESC,
                                        $cleanerArray);

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
                            @foreach($cleanerArray as $cleaners)
                            <?php
                                $cleaner_id = $cleaners['cleaner_id'];
                                $cleanerID = Cleaner::where('cleaner_id', $cleaner_id)->value('user_id');
                                $users = User::where('user_id', $cleanerID)->value('full_name');
                            ?>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Top {{$counter++}}
                                </th>
                                <td class="user_table_data">
                                    {{$users}}
                                </td>
                                <td class="user_table_data">
                                    {{number_format((float)$cleaners['rate'], 0, '.', '')}}/5 Stars
                                </td>
                                <td class="user_table_data">
                                    {{$cleaners['completed']}} Jobs
                                </td>
                                <td class="user_table_data">
                                    {{$cleaners['cancelled']}} Jobs
                                </td>
                            </tr>
                            @if($counter > 3)
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
                        <button type="button" class="btn btn-primary pay_btn" onclick="document.location='{{ route('cleaners_performance')}}'">
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
                                    <b>As of:</b> {{ \Carbon\Carbon::now()->format('l, F d, Y') }}
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
                                        @foreach($cleanerArray as $cleaners)
                                        <?php
                                            $cleaner_id = $cleaners['cleaner_id'];
                                            $cleanerID = Cleaner::where('cleaner_id', $cleaner_id)->value('user_id');
                                            $users = User::where('user_id', $cleanerID)->value('full_name');
                                        ?>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Top {{$count++}}
                                            </th>
                                            <td class="user_table_data">
                                                {{$users}}
                                            </td>
                                            <td class="user_table_data">
                                            {{number_format((float)$cleaners['rate'], 0, '.', '')}}/5 Stars
                                            </td>
                                            <td class="user_table_data">
                                            {{$cleaners['completed']}} Jobs
                                            </td>
                                            <td class="user_table_data">
                                            {{$cleaners['cancelled']}} Jobs
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer customer_trans_modal_footer">
                            <button type="button" class="btn btn-primary pay_btn" onclick="document.location='{{ route('cleaners_performance')}}'">
                                Generate Report
                            </button>
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

    <!-- Datatable -->
    <script>

        // Enable pusher logging 
        Pusher.logToConsole = true;

        var pusher = new Pusher('21a2d0c6b21f78cd3195', {
            cluster: 'ap1'
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
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

    <script>
        function avgIncome() {
            console.log("TESTING1");
            const canvas = document.getElementById('avgWeeklyIncome');
            const canvasImg = canvas.toDataURL('image/jpeg', 1.0);

            let pdf = new jsPDF();
            pdf.setFontSize(20);
            pdf.text(15, 15, "SWEEP Monthly Income");
            pdf.viewerPreferences({
                'FitWindow': true
            }, true);
            pdf.addImage(canvasImg, 'JPEG', 20, 20, 180, 100);
            pdf.text(15, 15, "This file was generated on ". date('F d, Y', strtotime($mytime)));
            pdf.save('SWEEP-Average-Income.pdf');
        }

        function avgBooking() {
            const usersReport1 = document.getElementById('avgWeeklyCust');
            const usersReportImg = usersReport1.toDataURL('image/jpeg', 1.0);

            let pdf1 = new jsPDF();
            pdf1.text(15, 15, "SWEEP Average Monthly Users");
            pdf1.viewerPreferences({
                'FitWindow': true
            }, true);
            pdf1.addImage(usersReportImg, 'JPEG', 20, 20, 180, 100);
            pdf.text(15, 15, "This file was generated on ". date('F d, Y', strtotime($mytime)));
            pdf1.save('SWEEP-Average-Booking.pdf');
        }

        function sweepRevenue() {
            const servicerevenueReport = document.getElementById('avgRevenueperService');
            const servicerevenueReportImg = servicerevenueReport.toDataURL('image/jpeg', 1.0);

            let pdf2 = new jsPDF();
            pdf2.setFontSize(20);
            pdf2.text(15, 15, "Revenues Per Service");
            pdf2.viewerPreferences({
                'FitWindow': true
            }, true);
            pdf2.addImage(servicerevenueReportImg, 'JPEG', 20, 20, 180, 180);
            pdf.text(15, 15, "This file was generated on ". date('F d, Y', strtotime($mytime)));
            pdf2.save('Sweep-Service-Revenue.pdf');
        }

        function requestedService() {

            const mostRequestedService = document.getElementById('mostRequestedService');
            const mostRequestedServiceImg = mostRequestedService.toDataURL('image/jpeg', 1.0);

            let pdf3 = new jsPDF();
            pdf3.setFontSize(20);
            pdf3.text(15, 15, "Most Popular Booked Service");
            pdf3.addImage(mostRequestedServiceImg, 'JPEG', 20, 20, 180, 180);
            pdf.text(15, 15, "This file was generated on ". date('F d, Y', strtotime($mytime)));
            pdf3.save('Sweep-Requested-Service.pdf');
        }

        function completionRatio() {
            const ratioReport = document.getElementById('ratio');
            const ratioReportImg = ratioReport.toDataURL('image/jpeg', 1.0);


            let pdf4 = new jsPDF();
            pdf4.setFontSize(20);
            pdf4.text(15, 15, "Ratio of Completed Jobs to Cancelled Jobs");
            pdf4.addImage(ratioReportImg, 'JPEG', 20, 20, 180, 180);
            pdf.text(15, 15, "This file was generated on ". date('F d, Y', strtotime($mytime)));
            pdf4.save('Service-Completion-Ratio.pdf');
        }
    </script>

    <!-- Footer -->
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>