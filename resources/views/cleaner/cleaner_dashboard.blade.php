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

@extends('head_extention_cleaner') 

@section('content')
<head>
<title>
        Cleaner Dashboard
    </title>

    <link href="{{ asset('css/cleaner.css') }}" rel="stylesheet">
    
    <script type="text/javascript"  id="gwt-pst" src="{{ asset('js/sweep.js')}}"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    
    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>

<div class="row cleaner_row_dashboard"> <!-- Sidebar --> 
        <div class="col-sm-3 cleaner_side_con">
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
            <div class="adjust_con_dash"> <!-- Search Field -->
                <input class="form-control searchbar_dash" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
            </div> 
            <?php
                $cleaner = Cleaner::Where('user_id', $LoggedUserInfo['user_id'])->value('cleaner_id');
                $bookingID = Assigned_cleaner::Where('cleaner_id', $cleaner)->Where('status', '!=', 'Declined')->get();
                ?>
                @foreach($bookingID as $key => $id)
            <?php
                $booking_data = Booking::Where('status', 'Pending')->Where('booking_id', $id->booking_id)->get();
            ?>
            @foreach($booking_data as $key => $value)
            <?php
                $service_data = Service::Where('service_id', $value->service_id )->get();
                $userID= Customer::Where('customer_id', $value->customer_id )->value('user_id');
                $user_data = User::Where('user_id', $userID )->get();
                $address = Address::Where('customer_id', $value->customer_id )->value('address');
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
        </div>
        <div class="container mt-5 calendar_con">
            <div id='calendar'></div>
            <?php
        $data = Event::all();
        ?>
        </div>
        
    </div> <!-- End of Sidebar -->
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
                        @foreach($data as $event)
                        {
                            
                            title: '{{$event->title}}',
                            start: '{{$event->start}}',
                            end: '{{$event->end}}'
                            
                        },
                        @endforeach
                    ],              
                });
 
});
 
function displayMessage(message) {
    toastr.success(message, 'Event');
} 
  
</script>
</body>
@endsection