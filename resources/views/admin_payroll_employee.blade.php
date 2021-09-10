@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Payroll Employee Page
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
        <a class="user_type_btn_cleaner" href="admin_payroll">
            ALL 
            <p class="total_value">
                ()
            </p>
        </a>
        <a class="user_type_btn_cleaner active_sub" href="admin_payroll_employee">
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

    <div class="user_table_con"> <!-- Employee Payroll Table --> 
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
                            Total Days Present
                        </th>
                        <th class="text-center user_table_header">
                            Rate
                        </th>
                        <th class="text-center user_table_header">
                            Total Salary
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="user_table_row">
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                        <td class="user_table_data"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- End of Employee Payroll Table --> 
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
