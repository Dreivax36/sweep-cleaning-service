<?php
    use App\Models\Booking;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
?>
@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Payroll Cleaner Page
    </title>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="admin_dashboard">
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
                    <a href="admin_payroll" class="active">
                        Payroll
                    </a>
                </li>
                <div class="profile_btn">
                <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img class="profile_img" src="/img/user.png">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            Logout
                        </a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar -->

    <div class="row user_btn_con"> <!-- Sub Header --> 
    <a class="user_type_btn_cleaner" style="font-size:25px; color: #FFB703; margin-top:100px; margin-left:100px;" href="admin_payroll">
            Payroll
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
                    $bookingID = Booking::Where('status', 'On-Progress')->get();
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
                    $price = $price / $cleanerCount;
                    $total = $total + $price;
                ?>
                @endforeach
                <?php
                    $id = Cleaner::Where('cleaner_id', $cleanerID)->value('user_id'); 
                    $fullname = User::Where('user_id', $id)->value('full_name'); 
                    $totalSalary = $total * 0.30;
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
    
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
    <script src="{{ asset('js/app.js') }}"></script>
</body>
@endsection
