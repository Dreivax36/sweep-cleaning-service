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
use App\Models\Time_entry;
?>
@extends('head_extention_admin')

@section('content')
<title>
 Employee Dashboard Page
</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

{{-- Scripts --}}
<script type="text/javascript" id="gwt-pst" src="{{ asset('js/sweep.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_dashboard.css')}}">

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
          <a href="admin_dashboard" class="nav-link" id="active"></a>
          <a class="nav-link" href="admin_services" role="button"></a>
          <a class="nav-link" href="admin_transaction" role="button"></a>
          <a class="nav-link" href="admin_user" role="button"></a>
          <a class="nav-link" href="admin_payroll" role="button"></a>
          <a class="nav-link" href="admin_reports" role="button"></a>
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

<body>
  <div class="row row_dashboard">
    <div class="col-md-3 col_dashboard_main">
      <div class="local_time_con">
        <div id="pst-container">
          <div class="local_time_title">
            Philippine Standard Time
          </div>
          <div id="pst-time" class="local_time"></div>
        </div>

        <form action="{{ route('timeIn') }}" method="post" id="myform">
          @if(Session::get('success-timein'))
            <script>
              swal({
              title: "Time In Successful!",
              icon: "success",
              button: "Close",
              });
            </script> 
          @endif
          @if(Session::get('success-timeout'))
            <script>
              swal({
              title: "Time Out Successful!",
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
          <input type="hidden" name="employee_id" value="{{$LoggedUserInfo['employee_id']}}">
          <?php
            $start = Time_entry::whereDate('created_at', Carbon::today())->where('employee_id', $LoggedUserInfo['employee_id'])->where('time_start', null)->count();
            $end = Time_entry::whereDate('created_at',  Carbon::today())->where('employee_id', $LoggedUserInfo['employee_id'])->where('time_end', null)->where('time_start', '!=', null)->count();
            $id = Time_entry::whereDate('created_at',  Carbon::today())->where('employee_id', $LoggedUserInfo['employee_id'])->where('time_end', null)->where('time_start', '!=', null)->value('id');
          ?>
          <input type="hidden" name="id" value="{{$id}}">
        <div class="buttons">
          <p>Time IN/Time OUT</p>
          @if($start == 0 && $end == 0)
          <button type="submit" class="btn btn-block btn-primary timein_btn" name="timeIn" value="{{now()->toDateTimeString()}}">
            TIME IN
          </button>
          <button type="submit" class="btn btn-block timeout_btn timein_btn" disabled>
            TIME OUT
          </button>
          @endif
          @if($end == 1)
          <button type="submit" class="btn btn-block btn-primary timein_btn" disabled>
            TIME IN
          </button>
          <button type="submit" class="btn btn-block timeout_btn timein_btn" name="timeOut" value="{{now()->toDateTimeString()}}">
            TIME OUT
          </button>
          @endif
        </div>
        </form>
      </div>
    <div class="col-md-9">
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