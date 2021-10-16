<?php
    use App\Models\Booking;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Notification;
?>
@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Payroll Cleaner Page
    </title>
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
                        <a href="admin_dashboard" class="nav-link">Home</a>
                        <a class="nav-link" href="admin_services" role="button" >Services</a>
                        <a class="nav-link" href="admin_transaction" role="button">Transactions</a>
                        <a class="nav-link" href="admin_user" role="button" >User</a>
                        <a class="nav-link" href="admin_payroll" role="button" id="active">Payroll</a>
                        <li class="nav-item dropdown" id="admin">
                            <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                              ?>
                           <a id="navbarDropdown admin" class="nav-link"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-bell"></i> 
                                @if($notifCount != 0)
                                <span class="badge alert-danger pending">{{$notifCount}}</span>
                                @endif
                            </a>    
                            <div class="wrapper" id="notification">
                            @include('notification')
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
<body >
    
    <div class="row user_btn_con"> <!-- Sub Header --> 
    <a class="user_type_btn_cleaner" style="font-size:25px; color: #FFB703; margin-top:50px; margin-left:85px;" href="admin_payroll">
            PAYROLL
        </a>
    </div> <!--End of Search Field --> 

    <div class="user_table_con" > <!-- Payroll Cleaner Table -->
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead>
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            Full Name
                        </th>
                        <th class="text-center user_table_header">
                            Total Job
                        </th>
                        <th class="text-center user_table_header">
                            Total Job Fee
                        </th>
                        <th class="text-center user_table_header">
                            Total Salary
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $cleaner = array();
                    $counter = 0;
                    $bookingID = Booking::Where('status', 'Completed')->get();
                ?>
                @foreach($bookingID as $key => $value)
                <?php
                    $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->value('cleaner_id');
                    $cleaner[$counter++] = $cleanerID;
                ?>
                @endforeach
                <?php
                    $cleaner = array_unique($cleaner); 
                ?>
                @foreach($cleaner as $key => $cleaner)
                    <?php
                    $totalSalary = 0;
                    $price = 0;
                    $total = 0;
                    $totalJob = 0; 
                    $booking = Assigned_cleaner::Where('cleaner_id', $cleaner)->get();
                    foreach($booking as $key => $booking){
                        $book = Booking::Where('booking_id', $booking->booking_id)->Where('status', 'Completed')->get();
                        foreach($book as $key => $book){
                        $price = Price::Where('service_id', $book->service_id)->Where('property_type', $book->property_type)->get();
                            foreach($price as $key => $price){
                            $salary = $price->price / $price->number_of_cleaner;   
                            $totalSalary = $totalSalary + $salary * 0.30;
                            $total = $total + $salary; 
                            }
                            $totalJob++;
                        }  
                    }
                    $id = Cleaner::Where('cleaner_id', $cleaner)->value('user_id'); 
                    $fullname = User::Where('user_id', $id)->value('full_name'); 
                
                    ?>
                    <tr class="user_table_row">
                        <td class="user_table_data">{{ $fullname }}</td>
                        <td class="user_table_data">{{ $totalJob }}</td>
                        <td class="user_table_data">₱{{ number_format((float)$total, 2, '.', '')}}</td>
                        <td class="user_table_data">₱{{ number_format((float)$totalSalary, 2, '.', '')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- End of Payroll Cleaner Table -->
    
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    
    <!-- Datatables Scripts -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

    <!-- Datatable -->
    <script>
        $(document).ready( function () {
            $('#user_table').DataTable();
        } );
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
            if(pending) {
                $('#admin').find('.pending').html(pending + 1);
            }else{
                $('#admin').append('<span class="badge alert-danger pending">1</span>');
            } 
        
        });

        $('.read').click (function(event){
            id = event.target.id;
            $.ajax({
            method: "GET",
            url: "/read/" + id
            });
        });

    $('#admin').click( function(){
        $.ajax({
        type: "get",
        url: "/notification",
        data: "",
        cache: false,
        success:function(data) {
            $data = $(data);
            $('#notification').hide().html($data).fadeIn();
        }
        });
    }); 

    </script>

    <!-- Scripts -->
    <footer id="footer">
    <div class="sweep-title">
        SWEEP © 2021. All Rights Reserved.
    </div>
</footer> 
</body>
@endsection
