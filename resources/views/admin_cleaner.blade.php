<?php
use App\Models\User;
use App\Models\Clearance;
use App\Models\Cleaner;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Admin Cleaner Page</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
                $('.menu-toggle').click(function(){
                    $('nav').toggleClass('active')
                })
            })
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
    <!-- Fonts -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
</head>
<body>
    <!-- Navbar -->  
    <header>
        <div class="logo"> SWEEP </div>
        <nav>
            <ul>
                <li><a href="admin_dashboard">Home</a></li>
                <li><a href="admin_services">Services</a></li>
                <li><a href="admin_transaction">Transaction</a></li>
                <li><a  class="active" href="admin_user">User</a></li>
                <li><a href="admin_payroll">Payroll</a></li>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img class="profile_img" src="/img/user.png">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header>
    <div class="row"> 
        <a class="user_type_btn_cleaner"  href="admin_user">
            ALL 
            <p class="total_value">(63)</p>
        </a>
        <a class="user_type_btn_cleaner" href="admin_customer">
            CUSTOMER 
            <p class="total_value">(63)</p>
        </a>
        <a class="user_type_btn_cleaner" id="active" href="admin_cleaner">
            CLEANER 
            <p class="total_value">(63)</p>
        </a>
    </div>
    <div class="search_con">
        <div>
            <input class="searchbar" type="text" placeholder="Search..">
            <button class="search_btn">Search</button>
        </div>
    </div>
    <p class="show_info"> Showing 1-10 of 63 results </p>
    <div class="result_con">
        <p class="show_info"> Results per page: </p>
        <button class="dropdown" id="number">10<span class="caret"></span></button>
    </div>
    
    <div class="user_table_con">
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead>
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">Full Name</th>
                        <th class="text-center user_table_header">Age</th>
                        <th class="text-center user_table_header">Address</th>
                        <th class="text-center user_table_header">Email Address</th>
                        <th class="text-center user_table_header">Contact Number</th>
                        <th class="text-center user_table_header">Valid ID</th>
                        <th class="text-center user_table_header">Requirement</th>
                        <th class="text-center user_table_header"></th>
                    </tr>
                </thead>
                <?php
                    $user_data = User::Where('user_type', 'Cleaner')->get();
                ?>
                @foreach($user_data as $key => $value)
                <?php
                    $cleaner_id = Cleaner::Where('user_id', $value->user_id)->value('cleaner_id');
                    $cleaner_id = Cleaner::Where('user_id', $value->user_id)->get();
                    $clearance_data = Clearance::Where('cleaner_id', $cleaner_id)->get();
                ?>
                @foreach($cleaner_id as $key => $cleaner)
                @foreach($clearance_data as $key => $clearance)
                <tbody>
                    <tr class="user_table_row">
                        <td class="user_table_data">{{ $value->full_name }}</td>
                        <td class="user_table_data">{{ $cleaner->age }}</td>
                        <td class="user_table_data">{{ $cleaner->address }}</td>
                        <td class="user_table_data">{{ $value->email }}</td>
                        <td class="user_table_data">{{ $value->contact_number }}</td>
                        <td class="user_table_data">{{ $value->valid_id }}</td>
                        <td class="user_table_data">{{ $clearance->description }}</td>
                        <td class="user_table_data">{{ $clearance->requirement }}</td>
                        <td class="user_table_data">
                            @if($value->account_status == "to_verify")
                            <button class="verifybutton">VERIFY</button>
                            @endif
                        </td>
                    </tr>
                </tbody>
                @endforeach
                @endforeach
                @endforeach 
            </table>
        </div>
    </div>
</body>
</html>