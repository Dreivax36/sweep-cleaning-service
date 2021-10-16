<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Notification;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Transaction History Page
    </title>
    <script src="{{ asset('js/app.js') }}"></script>
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
                        <a class="nav-link" href="admin_transaction" role="button"id="active">Transactions</a>
                        <a class="nav-link" href="admin_user" role="button">User</a>
                        <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
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
<body>
   
    <?php
        $booking_data = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->orderBy('updated_at','DESC')->get();
        $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
        $history_count = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->count();
    ?>
    <div class="row"> <!-- Sub Header -->  
        <a class="user_type_btn"  href="admin_transaction">
            TRANSACTION 
            <p class="total_value">
                ({{ $transaction_count }})
            </p>
        </a>
        <a class="user_type_btn" id="active" href="admin_transaction_history">
            HISTORY 
            <p class="total_value">
                ({{ $history_count }})
            </p>
        </a>
    </div>
  
    <div class="trans_his_con">  <!-- Transaction History Table -->
        <table class="table table-responsive-md table-hover" id="history_table">
            <thead class="row_title">
                <tr class="table_trans_his_row">
                    <th scope="col" class="user_table_trans_his_header">
                        Customer Name
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Service Name
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Property Type
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Service Fee
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Mode of Payment
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
            
            @foreach($booking_data as $key => $value)

            <?php
                $service = Service::Where('service_id', $value->service_id )->get();
                $userID = Customer::Where('customer_id', $value->customer_id )->value('user_id');
                $user = User::Where('user_id', $userID )->get();
            ?>
            @foreach($service as $key => $service_data)
            
            <?php
                $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();            
            ?>
            @foreach($price as $key => $price_data)
            @foreach($user as $key => $user_data)
            
                <tr class="table_trans_his_row">
                    <th class="user_table_trans_his_header">
                    {{ $user_data -> full_name }}
                    </th>
                    <td class="user_table_data">
                    {{ $service_data -> service_name }}
                    </td>
                    <td class="user_table_data">
                    {{ $value -> property_type }}
                    </td>
                    <td class="user_table_data">
                     ₱{{ $price_data -> price }}
                    </td>
                    <td class="user_table_data">
                        {{ $value -> mode_of_payment }}
                    </td>
                    <td class="user_table_data">
                    {{ $value -> status }}
                    </td>
                </tr>
            
            @endforeach
            @endforeach
            @endforeach
            @endforeach
            </tbody>
        </table>
    </div> <!-- End of Transaction History Table -->
     <!-- Scripts -->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    
    <!-- Datatables Scripts -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

    <!-- Datatable -->
    <script>
        $(document).ready( function () {
            $('#history_table').DataTable();
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
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="document.location='{{ route('auth.logout') }}'">Logout</button>
        </div>
        </div>
    </div>
    </div> 
</div> 
<footer id="footer">
    <div class="sweep-title">
        SWEEP © 2021. All Rights Reserved.
    </div>
</footer> 
</body>
@endsection
