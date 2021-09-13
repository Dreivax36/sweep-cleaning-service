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
        Admin Payroll Page
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
        <a class="user_type_btn_cleaner active_sub" href="admin_payroll">
            ALL 
            <p class="total_value">
                ()
            </p>
        </a>
        <a class="user_type_btn_cleaner " href="admin_payroll_employee">
            EMPLOYEE
            <p class="total_value">
                ()
            </p>
        </a>
        <a class="user_type_btn_cleaner " href="admin_payroll_cleaner">
            CLEANER 
            <p class="total_value">
                ()
            </p>
        </a>
    </div>

    <div class="user_table_con"> <!-- Payroll Table -->
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead>
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            Full Name
                        </th>
                        <th class="text-center user_table_header">
                            Total Salary
                        </th>
                        <th class="text-center user_table_header">
                            Sweep Revenue
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $total = 0;
                    $bookingID = Booking::Where('status', 'Pending')->get();
                ?>
                @foreach($bookingID as $key => $value)
                <?php
                    $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->value('cleaner_id');
                ?>
                 <?php
                    $booked = Assigned_cleaner::Where('cleaner_id', $cleanerID)->Where('booking_id', $value->booking_id)->get();
                ?>
                 @foreach($booked as $key => $book)
                 <?php
                    $payroll = Booking::Where('booking_id', $book->booking_id)->get();
                    foreach($payroll as $key => $pay){
                    $price = Price::Where('service_id', $pay->service_id)->Where('property_type', $pay->property_type)->value('price');
                    }
                    $total = $total + $price;
                ?>
                @endforeach
                <?php
                    $id = Cleaner::Where('cleaner_id', $cleanerID)->value('user_id'); 
                    $fullname = User::Where('user_id', $id)->value('full_name'); 
                    $total = $total * 0.30;
                    $revenue = $total * 0.70;
                ?>
               
                    <tr class="user_table_row">
                        <td class="user_table_data">{{ $fullname }}</td>
                        <td class="user_table_data"> {{ $total }}</td>
                        <td class="user_table_data">{{$revenue}}</td>
                    </tr>
                    @endforeach 
                </tbody>
                
            </table>
        </div>
    </div> <!-- End of Payroll Table -->
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
</body>
@endsection
