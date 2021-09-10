<?php
    use App\Models\User;
?>
@extends('head_extention_admin') 

@section('content')
    <title>
        Admin User Page
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
    <?php
        $user_data = User::all();
        $user_count = User::all()->count();
        $customer_count = User::Where('user_type', '=', 'Customer')->count();
        $cleaner_count = User::Where('user_type', '=', 'Cleaner')->count();
    ?>
    <div class="row user_btn_con"> <!-- Sub Header --> 
        <a class="user_type_btn_cleaner active_sub" href="admin_user">
            ALL 
            <p class="total_value">
            ({{ $user_count }})
            </p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_user_customer">
            CUSTOMER 
            <p class="total_value">
            ({{ $customer_count }})
            </p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_user_cleaner">
            CLEANER 
            <p class="total_value">
            ({{ $cleaner_count }})
            </p>
        </a>
    </div>

    <div class="user_table_con"> <!-- User Table -->
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead>
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            Full Name
                        </th>
                        <th class="text-center user_table_header">
                            Email Address
                        </th>
                        <th class="text-center user_table_header">
                            Contact Number
                        </th>
                        <th class="text-center user_table_header">
                            User Type
                        </th>
                        <th class="text-center user_table_header">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($user_data as $key => $value)
                    <tr class="user_table_row">
                        <td class="user_table_data">
                            {{ $value->full_name }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->email }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->contact_number }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->user_type }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->account_status }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- End of User Table --> 
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
