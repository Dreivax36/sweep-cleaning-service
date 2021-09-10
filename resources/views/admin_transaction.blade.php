<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Transaction
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
       
        $booking_data = Booking::Where('status', '!=', 'Completed')->Where('status', '!=', 'Declined')->Where('status', '!=', 'Cancelled')->get();
        $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
        $history_count = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->count();
    ?>
    <div class="row"> <!-- Sub Header -->  
        <a class="user_type_btn" id="active"  href="admin_transaction">
            TRANSACTION 
            <p class="total_value">
                ({{ $transaction_count }})
            </p>
        </a>
        <a class="user_type_btn"  href="admin_transaction_history">
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
    
    <div class="transaction_con">
    
        <div class="row row_transaction">
        @foreach($booking_data as $key => $value)
       
            @endforeach  
        </div>
    </div>
</body>
@endsection
