<?php

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Price;
use App\Models\Address;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Event;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\Service_review;
?>
@extends('head_extention_admin')

@section('content')
<title>
  Admin Dashboard Page
</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

{{-- Scripts --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_dashboard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">

  <script>
      function refreshTime(){
        var refresh = 1000;
        mytime = setTimeout('display_dateTime()', refresh);
      }

      function display_dateTime(){
        var date = new Date();
        document.getElementById("time").innerHTML = date.toLocaleTimeString();
        refreshTime();
      }
  </script>  
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
          <a href="admin_dashboard" class="nav-link" id="active">Home</a>
          <a class="nav-link" href="admin_services" role="button">Services</a>
          <a class="nav-link" href="admin_transaction" role="button">Transactions</a>
          <a class="nav-link" href="admin_user" role="button">User</a>
          <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
          <a class="nav-link" href="admin_reports" role="button">Reports</a>
          <!-- Notification -->
          <li class="nav-item dropdown" id="admin">
            <?php
            $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
            $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
            ?>
            <a id="navbarDropdown admin" class="nav-link admin" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <i class="fa fa-bell"></i>
              @if($notifCount != 0)
              <span class="badge alert-danger pending">{{$notifCount}}</span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
              @forelse ($notif as $notification)
              <a class="dropdown-item read" id="refresh" href="/{{$notification->location}}/{{$notification->id}}">
                <i class="fas fa-info-circle"></i> {{ $notification->message}}
              </a>
              @empty
              <a class="dropdown-item">
                No record found
              </a>
              @endforelse
            </div>
          </li>
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

<body onload="display_dateTime();">
  <div class="row row_dashboard">
    <div class="col-md-3 col_dashboard_main">
      <div class="local_time_con">
        <div id="pst-container">
          <div class="local_time_title">
            Philippine Standard Time
          
          <h3 id="time"></h3>
          <h6><?php echo \Carbon\Carbon::now()->format('l, F d, Y'); ?></h6>
          </div>
        </div>
      </div>
      <!-- Sidebar -->
      <h2 class="dashboard_title">
        Active Transactions
      </h2>
      <div class="adjust_con_dash">
        <!-- Search Field -->
        <input class="form-control searchbar_dash" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
      </div>
      <!-- Get active booking -->
      <?php
      $booking_data = Booking::Where('status', 'Accepted')->orWhere('status', 'On-Progress')->orWhere('status', 'On-the-Way')->get();
      ?>
      @if($booking_data != null)
      @foreach($booking_data as $key => $value)
      <?php
      $service_data = Service::Where('service_id', $value->service_id)->get();
      $userID = Customer::Where('customer_id', $value->customer_id)->value('user_id');
      $user_data = User::Where('user_id', $userID)->get();
      ?>
      @foreach($service_data as $key => $data)
      @foreach($user_data as $key => $user)

      <div class="row" id="card-lists">
        <div class="card active_services_con">
          <div class="d-flex card_body arrow_right_con">
            <h3 class="card-title service_name">
              {{ $data->service_name }}
            </h3>
            <div>
              <a href="admin_transaction">
                <span class="right"></span>
              </a>
            </div>
          </div>
          <p class="transaction_id">
            Transaction ID: {{ $value->booking_id }}
          </p>
          <p class="customer_name">
            <b>Customer:</b> {{ $user->full_name }}
          </p>
        </div>
      </div>
      @endforeach
      @endforeach
      @endforeach
      @else
      <div class="row justify-content-center">
        <h1 class="center">
          You currently have no Active Jobs.
        </h1>
      </div>
      @endif
    </div> <!-- End of Sidebar -->

    <div class="col-sm-9">
      <!-- Compute daily revenue, total revenue, sweep customer, sweep cleaner -->
      <?php
      $decline = Booking::where('status', 'Cancelled')->where('status', 'Declined')->count();
      $complete = Booking::where('status', 'Completed')->count();
      $services = Service::count();
      $satisfaction = Service_review::avg('rate');
      $total = 0;
      $revenue = 0;
      $totalToday = 0;
      $revenueToday = 0;
      $cleaner = User::where('user_type', 'Cleaner')->where('account_status', 'Validated')->count();
      $customer = User::where('user_type', 'Customer')->where('account_status', 'Validated')->count();
      $bookingRevenue = Booking::Where('status', 'Completed')->get();
      foreach ($bookingRevenue as $bookingRevenue) {
        $price = Price::where('service_id', $bookingRevenue->service_id)->where('property_type', $bookingRevenue->property_type)->value('price');
        $total = $total + $price;
      }
      $revenue = $total * 0.70;

      $bookingToday = Booking::where('status', 'Completed')->where('updated_at', Carbon::today())->get();
      foreach ($bookingToday as $bookingToday) {
        $priceToday = Price::where('service_id', $bookingToday->service_id)->where('property_type', $bookingToday->property_type)->value('price');
        $totalToday = $totalToday + $priceToday;
      }
      $revenueToday = $totalToday - ($totalToday * 0.50);
      ?>
      <!-- Reports -->
      <div class="row justify-content-center" id="report">
        <div class="daily_revenue spacing">
          <p class="report_title">
            Daily Revenue
          </p>
          <h3 class="value1">
            ₱ {{ number_format((float)$revenueToday, 2, '.', '')}}
          </h3>
        </div>

        <div class="weekly_revenue spacing">
          <h3 class="value">
            {{number_format((float)$satisfaction, 0, '.', '')}} / 5
          </h3>
          <p class="report_title">
            Overall Service Rating
          </p>
        </div>

        <div class="sweep_user spacing">
          <h3 class="value">
            {{ $complete }}
          </h3>
          <p class="report_title">
            Transaction Completed
          </p>
        </div>

        <div class="sweep_cleaner spacing">
          <h3 class="value">
            {{ $customer }}
          </h3>
          <p class="report_title">
            Sweep Customers
          </p>
        </div>
      </div> <!-- End of Reports -->

      <div class="row justify-content-center" id="report">
        <div class="daily_revenue spacing">
          <p class="report_title">
            Total Revenue
          </p>
          <h3 class="value1">
            ₱ {{ number_format((float)$revenue, 2, '.', '')}}
          </h3>
        </div>

        <div class="weekly_revenue spacing">
          <h3 class="value">
            {{$services}}
          </h3>
          <p class="report_title">
            Total Services
          </p>
        </div>

        <div class="sweep_user spacing">
          <h3 class="value">
            {{ $decline }}
          </h3>
          <p class="report_title">
            Transaction Cancelled
          </p>
        </div>

        <div class="sweep_cleaner spacing">
          <h3 class="value">
            {{$cleaner}}
          </h3>
          <p class="report_title">
            Sweep Cleaners
          </p>
        </div>
      </div>
      <!-- Booking Calendar -->
      <div class="container mt-5 calendar_con">
        <div id='calendar'></div>
        <?php
        $booking = Booking::Where('status', 'Accepted')->orwhere('status', 'On-Progress')->orwhere('status', 'On-the-Way')->get();
        ?>
      </div>
    </div>
  </div>

  <!-- Modal for logout -->
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

  <!-- Calendar -->
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
        ],
        eventColor: '#FFB703'
      });
    });

    function displayMessage(message) {
      toastr.success(message, 'Event');
    }
  </script>


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
      console.log(window.location.href + "+testing");
      //Reload Notification
      $('#refresh').load(window.location.href + " #refresh");
    });
  </script>
 
</body>
@endsection