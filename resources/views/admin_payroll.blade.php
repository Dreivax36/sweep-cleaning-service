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
                        <li class="nav-item dropdown">
                            <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->get();
                              ?>
                          
                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                    $total = 0;
                    $totalSalary = 0;
                    $bookingID = Booking::Where('status', 'Completed')->get();
                ?>
                @foreach($bookingID as $key => $value)
                <?php
                    $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->value('cleaner_id');
                    $cleanerCount = Assigned_cleaner::Where('booking_id', $value->booking_id)->count();
                ?>
                 <?php
                    $booked = Assigned_cleaner::Where('cleaner_id', $cleanerID)->Where('booking_id', $value->booking_id)->get();
                    $totalJob = Assigned_cleaner::Where('cleaner_id', $cleanerID)->Where('booking_id', $value->booking_id)->count();
                ?>
                 @foreach($booked as $key => $book)
                 <?php
                    $payroll = Booking::Where('booking_id', $book->booking_id)->get();
                    foreach($payroll as $key => $pay){
                    $price = Price::Where('service_id', $pay->service_id)->Where('property_type', $pay->property_type)->value('price');
                    }
                    $totalSalary = $totalSalary + $price * 0.30;
                    $price = $price / $cleanerCount;
                    $total = $total + $price;
                ?>
                @endforeach
                <?php
                    $id = Cleaner::Where('cleaner_id', $cleanerID)->value('user_id'); 
                    $fullname = User::Where('user_id', $id)->value('full_name'); 
                ?>
                    <tr class="user_table_row">
                        <td class="user_table_data">{{ $fullname }}</td>
                        <td class="user_table_data">{{ $totalJob }}</td>
                        <td class="user_table_data">{{ number_format((float)$total, 2, '.', '')}}</td>
                        <td class="user_table_data">{{ number_format((float)$totalSalary, 2, '.', '')}}</td>
                    </tr>
                @endforeach 
                </tbody>
            </table>
        </div>
    </div> <!-- End of Payroll Cleaner Table -->
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
    <!-- Scripts -->
    <footer id="footer">
    <div class="sweep-title">
        SWEEP © 2021. All Rights Reserved.
    </div>
</footer> 
</body>
@endsection
