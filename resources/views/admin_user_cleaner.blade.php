<?php
    use App\Models\User;
    use App\Models\Clearance;
    use App\Models\Cleaner;
    use App\Models\Identification;
?>
@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Cleaner Page
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
    <div class="row"> <!-- Sub Header --> 
    <a class="user_type_btn_cleaner" href="admin_user">
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
        <a class="user_type_btn_cleaner" id="active"  href="admin_user_cleaner">
            CLEANER 
            <p class="total_value">
            ({{ $cleaner_count }})
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
            10<span class="caret"></span>
        </button>
    </div> <!-- End of Sub Header --> 

    <div class="user_table_con"> <!-- Cleaner Tabler --> 
        <div class="table_detail_con">
            <table class="table user_table" id="user_table">
                <thead>
                    <tr class="user_table_row">
                        <th class="text-center user_table_header">
                            Full Name
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
                        <th class="text-center user_table_header">
                            Description
                        </th>
                        <th class="text-center user_table_header">
                            Requirement
                        </th>
                        <th class="text-center user_table_header">
                            
                        </th>
                    </tr>
                </thead>

                <?php
                    $user_data = User::Where('user_type', 'Cleaner')->get();
                ?>
                @foreach($user_data as $key => $value)

                <?php
                    $id = Cleaner::Where('user_id', $value->user_id)->value('cleaner_id');
                    $cleaner_id = Cleaner::Where('user_id', $value->user_id)->get();
                    $clearance_data = Clearance::Where('cleaner_id', $id)->get();
                    $valid_id = Identification::Where('user_id', $value->user_id )->value('valid_id');
                ?>
                @foreach($cleaner_id as $key => $cleaner)
                @foreach($clearance_data as $key => $clearance)

                <tbody>
                    <tr class="user_table_row">
                        <td class="user_table_data">
                            {{ $value->full_name }}
                        </td>
                        <td class="user_table_data">
                            {{ $cleaner->age }}
                        </td>
                        <td class="user_table_data">
                            {{ $cleaner->address }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->email }}
                        </td>
                        <td class="user_table_data">
                            {{ $value->contact_number }}
                        </td>
                        <td class="user_table_data">
                                 <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter-{{ $value->user_id }}">
                        view
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $value->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Valid ID</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card admin_profile_avatar_con">
                                    <img class="card-img-top profile_avatar_img" src="{{asset('/images/'.$valid_id ) }}" alt="profile_picture" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        </td>
                        <td class="user_table_data">
                            {{ $clearance->description }}
                        </td>
                        <td class="user_table_data">
                             <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter1-{{ $value->user_id }}">
                        view
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter1-{{ $value->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Requirement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card admin_profile_avatar_con">
                                    <img class="card-img-top profile_avatar_img" src="{{asset('/images/'.$clearance->requirement ) }}" alt="profile_picture" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        </td>
                        <td class="user_table_data">
                            @if($value->account_status == "To_verify")
                            <div class="verify_con">
                                <button class="btn btn-success" onclick="document.location='{{ route('update_account', $value->user_id) }}'">
                                    VERIFY
                                </button>
                            </div>
                            @endif
                            @if($value->account_status != "To_verify")
                                {{ $value->account_status }}
                            @endif
                        </td>
                    </tr>
                </tbody>
                @endforeach
                @endforeach
                @endforeach 
            </table>
        </div>
    </div> <!-- End of Cleaner Table -->
</body>
@endsection
