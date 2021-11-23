<?php
    use App\Models\Booking;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Notification;
    use App\Models\Employee;
    use App\Models\Salary;
?>
@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Payroll Employee Page
    </title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">

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
                        <a class="nav-link" href="admin_reports" role="button">Reports</a>
                        <!-- Notification -->
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
                            <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
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

<body >
    <?php
        $cleaner = Assigned_cleaner::distinct()->count('cleaner_id');
        $employee = Employee::all()->count();
    ?>
    <div class="row head">
    <div class="col-md-8">
    <div class="row user_btn_con"> <!-- Sub Header --> 
        <a class="user_type_btn_cleaner active_sub" href="admin_payroll">
            EMPLOYEE
            <p class="total_value">
            ({{ $employee}})
            </p>
        </a>
        <a class="user_type_btn_cleaner " href="admin_payroll_cleaner">
            CLEANER 
            <p class="total_value">
            ({{ $cleaner }})
            </p>
        </a>
    </div>
</div>
    <div class="col-md-4">
            <button type="button" class="btn btn-block btn-primary add_service_btn float-right" onclick="document.location='{{ route('computeSalary') }}'">
                Compute Salary
            </button>
    </div>
</div>

    <div class="user_table_con" > <!-- Payroll Cleaner Table -->
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead class="head_user">
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            Full Name
                        </th>
                        <th class="text-center user_table_header">
                            Total Hours Present
                        </th>
                        <th class="text-center user_table_header">
                           Date Generated
                        </th>
                        <th class="text-center user_table_header">
                            Total Salary
                        </th>
                        <th class="text-center user_table_header">
                            Total Tax
                        </th>
                        <th class="text-center user_table_header">
                            Net Take Home Pay
                        </th>
                        <th class="text-center user_table_header">
                           
                        </th>
                    </tr>
                </thead>
                <tbody>
        
                    <?php
                        $salary = Salary::orderBy('created_at', 'DESC')->get();
                    ?>
                    @foreach($salary as $salary)
                    <?php
                    $name = Employee::where('employee_code', $salary->employee_code)->value('full_name');
                    ?>
                    <tr class="user_table_row">
                        <td class="user_table_data">{{ $name }}</td>
                        <td class="user_table_data">{{ $salary->totalHour }}</td>
                        <td class="user_table_data">{{ date('F d, Y', strtotime($salary->created_at)) }}</td>
                        <td class="user_table_data">₱{{ number_format((float) $salary->totalsalary, 2, '.', '') }}</td>
                        <td class="user_table_data">₱{{ number_format((float)$salary->totaltax, 2, '.', '')}}</td>
                        <td class="user_table_data">₱{{ number_format((float)$salary->netpay, 2, '.', '')}}</td>
                        <td class="user_table_data">
                        <button type="submit" class="btn btn-block btn-success" onclick="document.location='{{ route('payslip', $salary->id) }}'">
                            Pay Slip
                        </button>
                        </td>
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
    @if(Session::has('success'))
    <script>
        swal({
            title: "Salary Computed Successfully!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif

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

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('21a2d0c6b21f78cd3195', {
            cluster: 'ap1'
        });
        var pos = "";
        if (window.innerWidth > 801) {
            pos = 'top-end';
        } else {
            pos = 'top';
        }

        const Toast = Swal.mixin({
            toast: true,
            position: pos,
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
            var admin_transaction = parseInt($('#admin').find('.admin_transaction').html());
            if (admin_transaction) {
                $('#admin').find('.admin_transaction').html(admin_transaction + 1);
            } else {
                $('#admin').find('.admin_transaction').html(admin_transaction + 1);
            }
            $('#refresh').load(window.location.href + " #refresh");
            $('#status').load(window.location.href + " #status");
        });
    </script>

</body>
@endsection
