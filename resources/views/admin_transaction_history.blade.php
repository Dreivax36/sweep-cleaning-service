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

    <div class="row"> <!-- Sub Header -->  
        <a class="user_type_btn"  href="admin_transaction">
            TRANSACTION 
            <p class="total_value">
                (63)
            </p>
        </a>
        <a class="user_type_btn" id="active" href="admin_transaction_history">
            HISTORY 
            <p class="total_value">
                (63)
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
                $booking_data = Booking::Where('status', 'Completed')->get();
            ?>
            @foreach($booking_data as $key => $value)

            <?php
                $service_data = Service::Where('service_id', $value->service_id )->get();
                $user_data = User::Where('user_id', $value->customer_id )->get();
                $price = Price::Where('property_type', $value->property_type )->get();
            ?>
            @foreach($service_data as $key => $data)
            @foreach($price as $key => $price_data)
            @foreach($user_data as $key => $user)

            <tbody>
                <tr class="table_trans_his_row">
                    <th class="user_table_trans_his_header">
                        Leah L. Cortez
                    </th>
                    <td class="user_table_data">
                        Light Cleaning
                    </td>
                    <td class="user_table_data">
                        Apartments 
                    </td>
                    <td class="user_table_data">
                        P342.00
                    </td>
                    <td class="user_table_data">
                        GCash
                    </td>
                    <td class="user_table_data">
                        CL001, CL002
                    </td>
                    <td class="user_table_data">
                        Completed
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