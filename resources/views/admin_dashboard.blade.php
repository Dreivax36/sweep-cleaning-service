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
    

<body>
  <header> <!-- Navbar -->
        <div class="logo"> 
          SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="admin_dashboard" class="active">
                        Home
                    </a>
                </li>
                <li>
                    <a href="admin_services">
                        Services
                    </a>
                </li>
                <li>
                    <a href="admin_transaction">
                        Transaction
                    </a>
                </li>
                <li>
                    <a href="admin_user">
                        User
                    </a>
                </li>
                <li>
                    <a href="admin_payroll">
                        Payroll
                    </a>
                </li>
                <li>
                              <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->get();
                              ?>
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-bell"></i> <span class="badge alert-danger">{{$notifCount}}</span>
                            </a> 

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                             
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
                  <li >
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
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
  </header> <!-- End of Navbar -->

  <div class="row row_dashboard"> 
    <div class="col-sm-3 col_dashboard_main">  <!-- Sidebar -->
      <h2 class="dashboard_title"> 
        Active Transactions
      </h2>
      <div class="adjust_con_dash"> <!-- Search Field -->
        <input class="form-control searchbar_dash" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
      </div> 

      <?php
        $booking_data = Booking::Where('status', 'Accepted' )->get();
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

</body>
@endsection