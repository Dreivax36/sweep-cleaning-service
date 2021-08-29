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

    <div class="row"> <!-- Sub Header --> 
        <a class="user_type_btn_cleaner" id="active" href="admin_payroll">
            ALL 
            <p class="total_value">
                (63)
            </p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_payroll_employee">
            EMPLOYEE
            <p class="total_value">
                (63)
            </p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_payroll_cleaner">
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

    <div class="user_table_con"> <!-- Payroll Table -->
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
                            Total Salary
                        </th>
                        <th class="text-center user_table_header">
                            Date Received
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="user_table_row">
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- End of Payroll Table -->
</body>
@endsection
