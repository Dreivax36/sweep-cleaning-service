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
                        <a href="admin_dashboard" class="nav-link" id="active">Home</a>
                        <a class="nav-link" href="admin_services" role="button">Services</a>
                        <a class="nav-link" href="admin_transaction" role="button">Transactions</a>
                        <a class="nav-link" href="admin_user" role="button">User</a>
                        <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
                        <li class="nav-item dropdown">
                            <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->get();
                              ?>
                          
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-bell"></i> <span class="badge alert-danger">{{$notifCount}}</span>
                            </a> 
                            
                            <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                             
                                @forelse ($notif as $notification)
                              <a class="dropdown-item" href="{{$notification->location}}">
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
                                <a class="dropdown-item" href="{{ route('auth.logout') }}">
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
    <div class="col-sm-3 col_dashboard_main">  <!-- Sidebar -->
      <h2 class="dashboard_title"> 
        Active Transactions
      </h2>
      <div class="adjust_con_dash"> <!-- Search Field -->
        <input class="form-control searchbar_dash" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
      </div> 

      <?php
        $booking_data = Booking::Where('status', 'Accepted' )->orWhere('status', 'On-Progress' )->get();
      ?>
      @foreach($booking_data as $key => $value)
      <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $userID= Customer::Where('customer_id', $value->customer_id )->value('user_id');
        $user_data = User::Where('user_id', $userID )->get();
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
            Transaction ID: {{ $value->booking_ID }}
          </p>
          <p class="customer_name"> 
            Customer: {{ $user->full_name }}
          </p>
        </div>
      </div>
      @endforeach
      @endforeach
      @endforeach
    </div> <!-- End of Sidebar -->

    <div class="col-sm-9">
     
      <div class="row" id="report"> <!-- Reports -->
        <div class="daily_revenue">
          <h3 class="value">
            2,873 php 
            </h3>
          <p class="report_title">
            Daily Revenue 
          </p>
        </div>
        <div class="weekly_revenue">
          <h3 class="value"> 
            17,243 php 
          </h3>
          <p class="report_title"> 
            Weekly Revenue 
          </p>
        </div>
        <div class="sweep_user">
          <h3 class="value"> 
            103 
          </h3>
          <p class="report_title"> 
            Sweep Users 
          </p>
        </div>
        <div class="sweep_cleaner">
          <h3 class="value"> 
            21 
          </h3>
          <p class="report_title"> 
            Sweep Cleaners 
          </p>
        </div>
      </div> <!-- End of Reports -->
     
      <div class="container mt-5 calendar_con">
            <div id='calendar'></div>
      <?php
        $booking = Booking::Where('status', 'Accepted')->orwhere('status', 'On-Progress')->orwhere('status', 'Done')->get();
      ?>
      </div>
      <div class="row" id="daily_transaction">
        <div class="container">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>
  </div>

<!-- Bar Graph -->
<script>
            $(document).ready(function () {
            
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var calendar = $('#calendar').fullCalendar({
                    editable: false,
                    header:{
                       left:'prev,next today',
                       center: 'title',
                       right:'month, agendaWeek, agendaDay'     
                    },
                    events: [
                        @foreach($booking as $id)
                        <?php   
                            $data = Event::Where('booking_id', $id->booking_id)->get();
                        ?>
                        @foreach($data as $event)
                        {
                            
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
  let myChart = document.getElementById('myChart').getContext('2d');
  let massPopChart = new Chart(myChart, {
    type: 'bar',
    data:{
      labels:[['Light', 'Cleaning'], ['Deep', 'Cleaning'], ['Deep Kitchen', 'Cleaning'], ['Upholstery', 'Cleaning'], ['Sanitation and Germ', 'Proofing'], ['Maid for', 'a Day']],
      datasets:[{
        label:'On-Progress', 
        data:[
          5,
          2,
          4,
          2,
          2,
          3
        ],
        backgroundColor:'#219EBC'
      }, {
        label:'Done', 
        data:[
          2,
          3,
          4,
          1,
          3,
          2
        ],
        backgroundColor:'#FB8500'
      }]
    },
    options:{
      title:{
        display:true,
        text:'Sweep Daily Transaction',
        fontSize:25,
        fontColor: "#000000" 
      },
      legend:{
        position:'right',
        labels:{
        fontColor:'#219EBC'
        }
      },
      layout:{
        padding: {
          left:50,
          right:0,
          bottom:0,
          top:0
        }
      },
      tooltips:{
        enabled:true
      }
    }
  });
</script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('21a2d0c6b21f78cd3195', {
    cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
    alert(JSON.stringify(data));
        if($.fn.dataTable.isDataTable('#requestTable')){
            $('#requestTable').DatabTable().clear();
            $('#requestTable').DatabTable().destroy();
        }

        $.ajax({
            method: "GET",
            url: "/request/refresh",
        }).done(function(data)){

            $('#requestList').html(data);
            var table = $('#requestTable').DatabTable({
                "scrollX": true,
                "order": [],
            });
        });
    });
    </script>
<footer id="footer">
    <div class="sweep-title">
        SWEEP © 2021. All Rights Reserved.
    </div>
</footer> 
</body>
@endsection
