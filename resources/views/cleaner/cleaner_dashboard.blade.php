<?php

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Price;
use App\Models\Address;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Assigned_cleaner;
use App\Models\Event;
?>

@extends('cleaner/cleaner-nav/head_extention_cleaner-home')

@section('content')

<head>
    <title>
        Cleaner Dashboard
    </title>

    <link href="{{ asset('css/cleaner.css') }}" rel="stylesheet">

    <script type="text/javascript" id="gwt-pst" src="{{ asset('js/sweep.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>

    <div class="row cleaner_row_dashboard">
        <!-- Sidebar -->
        <div class="col-md-3 cleaner_side_con">
            <div class="local_time_con">
                <div id="pst-container">
                    <div class="local_time_title">
                        Philippine Standard Time
                    </div>
                    <div id="pst-time" class="local_time"></div>
                </div>
            </div>
            <h2 class="side_con_title">
                On-Progress Jobs
            </h2>
            <div class="adjust_con_dash">
                <!-- Search Field -->
                <input class="form-control searchbar_dash" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
            </div>
            
            <?php
            $cleaner = Cleaner::Where('user_id', $LoggedUserInfo['user_id'])->value('cleaner_id');
            $bookingID = Assigned_cleaner::Where('cleaner_id', $cleaner)->Where('status', '!=', 'Declined')->orWhere('status', '!=', 'Cancelled')->orWhere('status', '!=', 'Completed')->get();
            $bookingCount = Assigned_cleaner::Where('cleaner_id', $cleaner)->Where('status', '!=', 'Declined')->Where('status', '!=', 'Cancelled')->Where('status', '!=', 'Completed')->count();
            ?>
            @if($bookingCount == 0)
            <div class="no-jobs">
                <h3>
                    You currently have no Active Jobs.
                </h3>
            </div>
            @endif
            @if($bookingID != null)
            @foreach($bookingID as $key => $id)
            <?php
            $booking_data = Booking::Where('booking_id', $id->booking_id)->get();
            ?>
            @foreach($booking_data as $key => $value)
            <?php
            $service_data = Service::Where('service_id', $value->service_id)->get();
            $userID = Customer::Where('customer_id', $value->customer_id)->value('user_id');
            $user_data = User::Where('user_id', $userID)->get();
            $address = Address::Where('customer_id', $value->customer_id)->value('address');
            ?>
            @foreach($service_data as $key => $data)
            @foreach($user_data as $key => $user)
            <div class="row" id="card-lists">
                <div class="card available_job_con">
                    <div class="d-flex card_body arrow_right_con">
                        <h3 class="card-title service_name">
                            {{ $data->service_name }}
                        </h3>
                        <div>
                            <a href="/cleaner/cleaner_job">
                                <span class="right"></span>
                            </a>
                        </div>
                    </div>
                    <h6 class="customer_info">
                        <b>Customer:</b> {{ $user->full_name }}
                    </h6>
                    <h6 class="customer_info">
                        {{ $user->contact_number }}
                    </h6>
                    <h6 class="customer_info">
                        {{$address}}
                    </h6>
                </div>
            </div>
            @endforeach
            @endforeach
            @endforeach
            @endforeach
            
            @endif
        </div>
        <?php
            $canceljobs = 0;
            $totaljobs = 0;
            $pendingjobs = 0;
            $booking = Booking::Where('status','!=', 'Cancelled')->get();
            foreach($booking as $booking){
                $id = $booking->booking_id;
                $cancel = Assigned_cleaner::Where('cleaner_id', $cleaner)->Where('booking_id', $id)->Where('status', 'Declined')->count();
                $done = Assigned_cleaner::Where('cleaner_id', $cleaner)->Where('booking_id', $id)->Where('status', 'Completed')->count();
                $pending = Assigned_cleaner::Where('cleaner_id', $cleaner)->Where('booking_id',$id)->Where('status', '!=', 'Done')->Where('status', '!=', 'Declined')->Where('status', '!=', 'Cancelled')->Where('status', '!=', 'Completed')->count();
                if($cancel == 1){
                    $canceljobs++;
                }
                if($done == 1){
                    $totaljobs++;
                }
                if($pending == 1){
                    $pendingjobs++;
                }
            }
           
            $totalSalary = 0;
            $booking = Assigned_cleaner::Where('cleaner_id', $cleaner)->get();
            foreach($booking as $key => $booking){
                $book = Booking::Where('booking_id', $booking->booking_id)->Where('status', 'Completed')->get();
                foreach($book as $key => $book){
                $price = Price::Where('service_id', $book->service_id)->Where('property_type', $book->property_type)->get();
                    foreach($price as $key => $price){
                    $salary = $price->price / $price->number_of_cleaner;   
                    $totalSalary = $totalSalary + $salary * 0.30;
                    }
                }  
            }
            ?>
        <div class="col-md-9">
            <div class="row justify-content-center" id="report">
                <!-- Reports -->
                <div class="weekly_revenue">
                    <h3 class="value">
                        {{$pendingjobs}}
                    </h3>
                    <p class="report_title">
                        Pending Jobs
                    </p>
                </div>
                <div class="weekly_revenue">
                    <h3 class="value">
                       {{$canceljobs}}
                    </h3>
                    <p class="report_title">
                        Cancelled Jobs
                    </p>
                </div>
                <div class="weekly_revenue">
                    <h3 class="value">
                        {{$totaljobs}}
                    </h3>
                    <p class="report_title">
                    Job Commissioned
                    </p>
                </div>
                <div class="weekly_revenue">
                    <h3 class="value">
                    {{ number_format((float)$totalSalary, 2, '.', '')}} php
                    </h3>
                    <p class="report_title">
                    Total Earned Salary
                    </p>
                </div>
            </div> <!-- End of Reports -->
            
                <div id='calendar'></div>
                <?php
                    $bookingEvent = Booking::Where('status', '!=', 'Pending')->Where('status', '!=', 'Done')->Where('status', '!=', 'Declined')->Where('status', '!=', 'Cancelled')->Where('status', '!=', 'Completed')->get();
                ?>
        
            <script>
                $(document).ready(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var calendar = $('#calendar').fullCalendar({
                        editable: false,
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month, agendaWeek, agendaDay'
                        },

                        events: [
                            @foreach($bookingEvent as $bookings)
                            <?php
                            $booking = Assigned_cleaner::Where('booking_id', $bookings->booking_id)->Where('cleaner_id', $cleaner)->Where('status', 'Accepted')->orwhere('status', 'On-Progress')->orwhere('status', 'On-the-Way')->get();
                            ?>
                            @foreach($booking as $id)
                            <?php
                            $data = Event::Where('booking_id', $id->booking_id)->get();
                            ?>
                            @foreach($data as $event) {

                                title: '{{$event->title}}',
                                start: '{{$event->start}}',
                                end: '{{$event->end}}'

                            },
                            @endforeach
                            @endforeach
                            @endforeach
                        ],
                        eventColor: '#FFB703'
                    });

                });

                function displayMessage(message) {
                    toastr.success(message, 'Event');
                }
            </script>
        </div>
    </div>
    <div class="mobile-spacer">
        <br>
    </div>
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>
@endsection