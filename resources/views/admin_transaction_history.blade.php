<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Transaction History</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
                $('.menu-toggle').click(function(){
                    $('nav').toggleClass('active')
                })
            })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
</head>
<body >
    <header>
        <div class="logo"> SWEEP </div>
        <nav>
            <ul>
                <li><a  href="admin_dashboard">Home</a></li>
                <li><a  href="admin_services">Services</a></li>
                <li><a class="active" href="admin_transaction">Transaction</a></li>
                <li><a href="admin_user">User</a></li>
                <li><a href="admin_payroll">Payroll</a></li>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img class="profile_img" src="/img/user.png">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header>
    <div class="row"> 
        <a class="user_type_btn"  href="admin_transaction">
            TRANSACTION 
            <p class="total_value">(63)</p>
        </a>
        <a class="user_type_btn" id="active" href="admin_transaction_history">
            HISTORY 
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
    <div class="trans_his_con">
        <table class="table table-responsive-md table-hover">
            <thead class="row_title">
                <tr class="table_trans_his_row">
                <th scope="col" class="user_table_trans_his_header">Customer Name</th>
                <th scope="col" class="user_table_trans_his_header">Service Name</th>
                <th scope="col" class="user_table_trans_his_header">Property Type</th>
                <th scope="col" class="user_table_trans_his_header">Service Fee</th>
                <th scope="col" class="user_table_trans_his_header">Mode of Payment</th>
                <th scope="col" class="user_table_trans_his_header">Cleaner ID</th>
                <th scope="col" class="user_table_trans_his_header">Status</th>
                </tr>
            </thead>
            <?php
        $booking_data = Booking::Where('status', 'Done')->get();
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
                <th class="user_table_trans_his_header">Leah L. Cortez</th>
                <td class="user_table_data">Light Cleaning</td>
                <td class="user_table_data">Apartments </td>
                <td class="user_table_data">P342.00</td>
                <td class="user_table_data">GCash</td>
                <td class="user_table_data">CL001, CL002</td>
                <td class="user_table_data">Completed</td>
            </tr>
           
        </tbody>
        @endforeach
        @endforeach
        @endforeach
        @endforeach
        </table>
    </div>
</body>
</html>