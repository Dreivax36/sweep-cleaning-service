<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Review;
    use App\Models\Notification;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Transaction
    </title>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light sweep-nav shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brandname" href="{{ url('/') }}">
                    SWEEP
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class= "navbar-nav ml-auto">    
                        <a href="admin_dashboard" class="nav-link">Home</a>
                        <a class="nav-link" href="admin_services" role="button">Services</a>
                        <a class="nav-link" href="admin_transaction" role="button" id="active">Transactions</a>
                        <a class="nav-link" href="admin_user" role="button">User</a>
                        <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
                        <li class="nav-item dropdown">
                            <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->get();
                              ?>
                          
                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-bell"></i> <span class="badge alert-danger">{{$notifCount}}</span>
                            </a> 
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                             
                                @forelse ($notif as $notification)
                              <a class="dropdown-item" href="{{$notification->location}}">
                                    {{ $notification->message}}
                                </a>
                              @empty
                                <a class="dropdown-item">
                                    No record found
                                </a>
                              @endforelse
                            </div>

                  </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $LoggedUserInfo['email'] }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                    Logout
                                </a>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
<body>

    <div class="col-sm-9">
            <div class="search_con"> <!-- Search Field -->
                <input class="form-control searchbar" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()">
            </div> 
        </div>
    </div>
    <?php
        $booking_data = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->orderBy('updated_at','DESC')->get();
        $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'On-Progress')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
        $history_count = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->count();
    ?>
    <div class="row user_btn_con"> <!-- Sub Header -->  
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
    <div class="transaction_con">
    
        <div class="row row_transaction">
        @if($booking_data != null )
        @foreach($booking_data as $key => $value)
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $userId = Customer::Where('customer_id', $value->customer_id )->value('user_id');
        $user_data = User::Where('user_id', $userId )->get();
        $address = Address::Where('customer_id', $value->customer_id )->value('address');
    ?>
            <div class="column col_transaction" id="card-lists">
                <div class="card card_transaction p-4">
                    <div class="d-flex card_body">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        @foreach($service_data as $key => $data)
                        <h3 class="card-title  service_title_trans">
                            {{ $data->service_name }}
                        </h3>
                        <h5 class="service_status">
                            {{ $value->status }}
                        </h5>
                    </div>
                    <div> 
                        <h6 class="booking_date">
                            <b>Scheduled:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }} </h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            @foreach($user_data as $user)
                            
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Customer:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $user->full_name }}
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Address:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $address }}
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Contact Info:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $user->contact_number }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                            View Details
                        </button>
                    </div> 
                </div>
            </div>          
                    <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 trans_modal_content"> <!-- Modal Content-->
                                <div class="modal-header trans_modal_header">
                                    <div class="d-flex pt-5">
                                        <i class="bi bi-card-checklist check_icon_inside"></i>
                                        <h4 class="modal_service_title_trans">
                                            {{ $data->service_name }}
                                        </h4>
                                    </div>
                                    
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <form action="{{ route('updateStatus') }}" method="post" >
                                    @if(Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if(Session::get('fail'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('fail') }}
                                        </div>
                                    @endif

                                    @csrf
                                    {{ csrf_field() }}
                                    <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                    <input type="hidden" name="service_id" value="{{ $value->service_id }}">
                                    
                                   
                                        <ul class="customer_detail">
                                            <li>
                                                <b>Customer:</b>
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Name:</b> {{ $user->full_name }}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Contact Number:</b> {{ $user->contact_number }}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Address:</b> {{ $address }}
                                            </li>
                                            <br>
                                            <li>
                                                <b>Service:</b>
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                            </li>
                                            <?php
                                            $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();
                                            ?>
                                            @foreach($price as $price_data)
                                            <li class="list_booking_info">
                                                <b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Property Type:</b> {{ $value->property_type}}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Status:</b> {{ $value->status }}
                                            </li>
                                            <li class="list_booking_info">
                                                <b>Price:</b> P{{ $price_data->price }}
                                            </li>
                                            <br>
                                            
                                            <?php
                                                $id = Assigned_cleaner::Where('booking_id', $value->booking_id )->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                            ?> 
                                            
                                            <li>
                                                <b>Cleaners:</b>
                                            </li>
                                            @if($id != null)
                                            @foreach($id as $cleaner)
                                            <?php

                                                $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id )->value('user_id');
                                                $full = User::Where('user_id', $user_id )->value('full_name');

                                            ?>
                                            <li class="list_booking_info">
                                                <b>Name:</b> {{ $full }}
                                            </li>
                                            @endforeach  
                                            @endif
                                            
                                        </ul>
                                    
                                    
                                
                                <?php
                                    $bookingcount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->count();
                                    $statuscount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Accepted")->count();
                                ?>
                                <div class="modal-footer trans_modal_footer">
                                    @if($value->status == "Pending" && $statuscount != $price_data->number_of_cleaner && $bookingcount != $price_data->number_of_cleaner )
                                        <button type="button" class="btn btn-block btn-primary accept_btn" data-dismiss="modal" data-toggle="modal" data-target="#assign-{{ $value->booking_id }}">
                                            ASSIGN
                                        </button>
                                    @endif
                                    @if($value->status == "Pending" && $statuscount == $price_data->number_of_cleaner ) <!-- add is_paid -->
                                        <button  type="submit" class="btn btn-block btn-primary accept_btn" name="status" value="Accepted">
                                            ACCEPT
                                        </button>
                                    @endif
                                    @if($value->status == "Pending" && $bookingcount != $price_data->number_of_cleaner )    
                                        <button  type="submit" class="btn btn-block btn-primary decline_btn" name="status" value="Declined">
                                            DECLINE
                                        </button>
                                    @endif
                                    <?php
                                        $statusOnProgress = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "On-Progress")->count();
                                        $statusdone = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Done")->count();
                                        $reviews = Review::Where('booking_id', '=', $value->booking_id)->count();
                                    ?>
                                    @if($value->status == "Accepted" && $statusOnProgress == $price_data->number_of_cleaner )
                                    <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-Progress" >
                                             ON-PROGRESS
                                         </button>    
                                     @endif    
                                    @if($value->status == "On-Progress" && $statusdone == $price_data->number_of_cleaner)
                                     <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Done" >
                                              DONE
                                     </button> 
                                     @endif 
                                     @if($value->status == "Done" && $value->is_paid == true && $reviews != 0)
                                     <button class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Completed" >
                                              COMPLETE
                                     </button> 
                                     @endif 
                                </div>
                                </form>
                            </div>
                        @endforeach  
                        @endforeach 
                        </div> <!-- End of Modal Content -->   
                    </div><!-- End of Modal -->
                            <div class="modal-footer customer_services_modal_footer">
                                <div class="modal fade" id="assign-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal --> 
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content p-3 trans_modal_content">  <!-- Modal content-->
                                            <div class="modal-header trans_modal_header">
                                                <div class="d-flex pt-5">
                                                    <h4 class="modal_service_title_trans">
                                                        Assign Cleaner
                                                    </h4>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            
                                            <form action="{{ route('assignCleaner') }}" method="post" >
                                                @if(Session::get('success'))
                                                    <div class="alert alert-success">
                                                        {{ Session::get('success') }}
                                                    </div>
                                                @endif

                                                @if(Session::get('fail'))
                                                    <div class="alert alert-danger">
                                                        {{ Session::get('fail') }}
                                                    </div>
                                                @endif                  
                                                @csrf
                                                {{ csrf_field() }}
                                                    <?php  
                                                        $total = $price_data->number_of_cleaner;
                                                        $cleaner_data = User::Where('user_type', 'Cleaner')->Where('account_status', 'Verified')->get(); 
                                                        $cleanerCount = Assigned_cleaner::Where('booking_id', $value->booking_id)->count();
                                                    ?>
                                                    @while($total > 0)
                                                    <input type= "hidden" name="booking_id" value="{{ $value->booking_id }}">
                                                    <input type="hidden" name="status" value="Pending">
                                                    <label for="cleaner">Cleaner: </label>
                                                    <select name="cleaner_id[]" id="cleaner">
                                                    @if ($cleanerCount == 0)
                                                        @if($cleaner_data != null)
                                                            @foreach($cleaner_data as $key => $cleaner)
                                                                <?php
                                                                    $fullname = User::Where('user_id', $cleaner->user_id )->value('full_name');
                                                                ?>    
                                                                <option  value="{{  $cleaner->user_id }}">{{ $fullname }}</option>
                                                            @endforeach 
                                                        @endif
                                                    @else    
                                                        @if($cleaner_data != null)
                                                        <?php  
                                                            $cleanerID = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', 'Accepted')->orWhere('status', 'Declined')->orWhere('status', 'Pending')->get();        
                                                        ?>
                                                        @foreach($cleaner_data as $key => $cleaner)
                                                            @foreach($cleanerID as $key => $assignCleaner)
                                                                <?php
                                                                    $assignUser = Cleaner::Where('cleaner_id', $assignCleaner->cleaner_id )->value('user_id');
                                                                ?> 
                                                                @if($cleaner->user_id != $assignUser)
                                                                    <?php $exist = true;?>
                                                                @else
                                                                    <?php $exist = false;?>
                                                                @endif    
                                                            @endforeach
                                                            @if($exist)
                                                                <?php
                                                                    $fullname = User::Where('user_id', $cleaner->user_id )->value('full_name');
                                                                ?>    
                                                                <option  value="{{ $cleaner->user_id }}">{{ $fullname }}</option>
                                                            @endif
                                                        @endforeach 
                                                        @endif
                                                    @endif
                                                    </select> <br>  
                                                    <?php
                                                        $total --;
                                                    ?>
                                                    @endwhile
                                                <br>
                                                <div class="modal-footer trans_modal_footer">
                                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal"> 
                                                        Cancel 
                                                    </button>
                                                    <button type="submit" class="btn btn-block btn-primary accept_btn"> 
                                                        Confirm 
                                                    </button>
                                                </div>
                                            </form> 
                                        </div> <!-- End of Modal Content --> 
                                    </div>
                                </div>
                            </div>
                    @endforeach       
            @endforeach 
            @endif 
        </div>
    </div>
    <footer id="footer">
    <div class="sweep-title">
        SWEEP © 2021. All Rights Reserved.
    </div>
</footer> 
</body>
@endsection
