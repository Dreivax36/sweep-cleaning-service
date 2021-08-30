<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Transaction History Page
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
                    <a href="admin_transaction"  class="active">
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
    <?php
        $booking_data = Booking::Where('status', '=', 'Completed')->Where('status', '=', 'Declined')->get();
        $transaction_count = Booking::Where('status', '!=', 'Completed')->Where('status', '!=', 'Declined')->count();
        $history_count = Booking::Where('status', '=', 'Completed')->orWhere('status', '=', 'Declined')->count();
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
    <div class="search_con"> <!-- Search Field -->
        <div>
            <input class="searchbar" type="text" placeholder="Search..">
            <button class="search_btn">
                Search
            </button>
        </div>
    </div> <!-- End of Search Field -->
    <p class="show_info"> 
        Showing 1-10 of 63 results 
    </p>
    <div class="result_con">
        <p class="show_info"> 
            Results per page: 
        </p>
        <button class="dropdown" id="number">
            10
            <span class="caret"></span>
        </button>
    </div>  <!-- End of Sub Header -->
  
    <div class="trans_his_con">  <!-- Transaction History Table -->
        <table class="table table-responsive-md table-hover">
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
                        Cleaner ID
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Status
                    </th>
                </tr>
            </thead>

            <?php
                $booking_data = Booking::Select('service_id','customer_id','property_type','mode_of_payment',)->Where('status', 'Completed')->orWhere('status', '=', 'Declined')->get();
            ?>
            @foreach($booking_data as $key => $value)

            <?php
                $service = Service::Where('service_id', $value->service_id )->get();
                $user = User::Where('user_id', $value->customer_id )->get();
            ?>
            @foreach($service as $key => $service_data)
            
            <?php
                $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();            
            ?>
            @foreach($price as $key => $price_data)
            @foreach($user as $key => $user_data)
            <tbody>
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
                        P{{ $price_data -> price }}
                    </td>
                    <td class="user_table_data">
                        {{ $value -> mode_of_payment }}
                    </td>
                    <td class="user_table_data">
                 <!-- {{ $value -> cleaner_id }} -->       
                    </td>
                    <td class="user_table_data">
                    {{ $value -> status }}
                    </td>
                </tr>
            </tbody>
            @endforeach
            @endforeach
            @endforeach
            @endforeach
        </table>
    </div> <!-- End of Transaction History Table -->
</body>
@endsection