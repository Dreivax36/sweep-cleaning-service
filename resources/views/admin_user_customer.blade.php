<?php
    use App\Models\User;
    use App\Models\Address;
    use App\Models\Customer;
?>
@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Customer Page
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
                    <a href="admin_user" class="active">
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
        <a class="user_type_btn_cleaner" id="active" href="admin_user">
            ALL 
            <p class="total_value">
                (63)
            </p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_user_customer">
            CUSTOMER 
            <p class="total_value">
                (63)
            </p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_user_cleaner">
            CLEANER 
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
    </div> <!--End of Search Field --> 
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
    </div> <!-- End of Sub Header --> 

    <div class="user_table_con"> <!-- Customer Table -->
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead>
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            First Name
                        </th>
                        <th class="text-center user_table_header">
                            Last Name
                        </th>
                        <th class="text-center user_table_header">
                            Age
                        </th>
                        <th class="text-center user_table_header">
                            Address
                        </th>
                        <th class="text-center user_table_header">
                            Email Address
                        </th>
                        <th class="text-center user_table_header">
                            Contact Number
                        </th>
                        <th class="text-center user_table_header">
                            Valid ID
                        </th>
                    </tr>
                </thead>
               
                <?php
                    $user_data = User::Where('user_type', 'Customer')->get();
                ?>
                @foreach($user_data as $key => $value)
                
                <?php
                    $customer_id = Customer::Where('user_id', $value->user_id)->value('customer_id');
                    $address_data = Address::Where('customer_id', $customer_id)->get();
                ?>
                @foreach($address_data as $key => $data)
                
                <tbody>
                    <tr class="user_table_row">
                        <td class="user_table_data">
                            {{ $value->full_name }}
                        </td>
                        <td class="user_table_data">
                            {{ $data->address }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->email }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->contact_number }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->valid_id }}
                        </td>
                        <td class="user_table_data">
                            @if($value->account_status == "to_verify")
                            <div class="verify_con">
                                <button class="verifybutton">
                                    VERIFY
                                </button>
                            </div>
                            @endif
                        </td>
                    </tr>
                </tbody>
                @endforeach
                @endforeach 
            </table>
        </div>
    </div> <!-- End of Customer Table -->
</body>
@endsection
