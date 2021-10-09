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

@extends('cleaner/cleaner-nav/head_extention_cleaner-jobs') 

@section('content')
    <title>
        Cleaner Job Page
    </title>
    <link href="{{ asset('css/style_cleaner.css') }}" rel="stylesheet">
<body>

    <div class="col-2 d-flex cleaner_job_title_con">
        <div>
            <h1 class="cleaner_cards_title">
                Jobs
            </h1> 
        </div>
    </div>
    <?php
        $cleanerID = Cleaner::Where('user_id', $LoggedUserInfo['user_id'])->value('cleaner_id');
        $bookingID = Assigned_cleaner::Where('cleaner_id', $cleanerID)->Where('status' , '!=' , 'Declined')->get();
    ?>
    
    <div class="cleaner_job_con">
        
        <div class="row row_cleaner_job">
        @if($bookingID != null)
        @foreach($bookingID as $key => $booking)
        <?php
            $booking_data = Booking::Where('status', 'Pending' )->orWhere('status', 'Accepted' )->orWhere('status', 'On-Progress' )->orderBy('updated_at','DESC')->get();
        ?>
        @foreach($booking_data as $key => $value)
        @if($booking->booking_id == $value->booking_id)
        <?php
            $service_name = Service::Where('service_id', $value->service_id )->value('service_name');
            $userID = Customer::Where('customer_id', $value->customer_id )->value('user_id');
            $user_data = User::Where('user_id', $userID)->get();
            $address = Address::Where('customer_id', $value->customer_id )->value('address');
            $price = Price::Where('property_type', $value->property_type )-> Where('service_id', $value->service_id )->get();       
        ?>
            <div class="column col_cleaner_job">
                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">  
                        <div class="d-flex flex-column">
                            <h5 class="cleaner_job_status">
                                {{ $value->status }}
                            </h5>
                            
                            <h3 class="cleaner_job_title">
                                {{ $service_name}}
                            </h3>
                            <h6 class="cleaner_job_date_1_1">
                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                            </h6>
                            
                            @foreach($price as $key => $price_data)
                            <h6 class="cleaner_job_price_1">
                                P{{ $price_data->price }}
                            </h6>
                        
                    
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                                    DETAILS
                                </button>
                            </div>
                            </div>
                        </div>
                </div>
            </div>        
                        <div class="modal-footer customer_services_modal_footer">
                            <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                <div class="modal-dialog" role="document">
                                            <div class="modal-content p-4 cleaner_job_modal_content">
                                                <div class="modal-header cleaner_job_modal_header">
                                                <div class="d-flex pt-5">
                                                    <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                                    <div class="d-flex flex-column">
                                                        <h4 class="cleaner_job_modal_title">
                                                            {{ $service_name}}
                                                        </h4>
                                                        <h6 class="cleaner_job_modal_date_1_1">
                                                            {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                        </h6>
                                                        <h6 class="cleaner_job_modal_amount_1">
                                                            Total Amount: P{{ $price_data->price }}
                                                        </h6>
                                                    </div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                               
                                                    <div class="cleaner_job_modal_body_1_con">
                                                        <ul class="cleaner_detail">
                                                        @foreach($user_data as $key => $user)
                               
                                                            <li>
                                                                <b>Customer:</b>
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Name:</b> {{ $user->full_name }}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Contact Number:</b> {{ $user->contact_number }}
                                                            </li>
                                                        @endforeach
                                                            <li class="list_booking_info">
                                                                <b>Address:</b> {{ $address }}
                                                            </li>
                                                            <br>
                                                            <li>
                                                                <b>Service Details:</b>
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Property Type:</b> {{ $value->property_type}}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Status:</b> {{ $value->status }}
                                                            </li>
                                                            <br>
                                                            <li>
                                                                <b>Payment:</b>
                                                            </li>
                                                            <li class="list_booking_info">
                                                                <b>Mode of Payment:</b> {{ $value->mode_of_payment }}
                                                            </li>
                                                            @if ( $value->mode_of_payment == 'Paypal')
                                                            <li class="list_booking_info">
                                                                <b>Paypal ID:</b> {{ $value->paypal_orderid }}
                                                            </li>
                                                            @endif
                                                            @if ( $value->is_paid == true)
                                                            <li class="list_booking_info">
                                                                <b>Status:</b> Paid
                                                            </li>
                                                            @endif
                                                            <br>
                                                        </ul>
                                                    </div>
                                                
                                                @endforeach 
                                                <form action="{{ route('cleaner') }}" method="post" id="cleaner"> <!-- Modal Content-->
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
                                                    
                                                    <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                                    <input type="hidden" name="cleaner_id" value="{{ $cleanerID }}">
                                                    
                                                
                                                
                                                <?php
                                                    $statuscount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('cleaner_id', '=', $cleanerID)->Where('status', '=', "Accepted")->count();       
                                                ?>
                                                
                                                <div class="modal-footer cleaner_job_modal_footer">
                                                        @if($value->status == "Pending" && $statuscount != $price_data->number_of_cleaner)
                                                            <button  class="btn btn-block btn-primary accept_btn" type="submit" name="status" value="Accepted" >
                                                                CONFIRM BOOKING
                                                            </button> 
                                                            <button  class="btn btn-block btn-danger decline_btn" type="submit" name="status" value="Declined" >
                                                                DECLINE
                                                            </button> 
                                                        @endif   
                                                            @if($value->status == "Accepted" )
                                                            <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-Progress" >
                                                                ON-PROGRESS
                                                            </button>    
                                                            @endif    
                                                            @if($value->status == "On-Progress")
                                                            <button class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Done" >
                                                                CLEANING COMPLETE
                                                            </button> 
                                                            @endif   
                                                </div> 
                                                </form>
                                            </div><!-- End of Modal Content -->
                                            </div> 
                                </div>
                                </div><!-- End of Modal --> 
            @endif
            @endforeach 
            @endforeach 
            @endif     
        </div>   
    </div>
</body>
@endsection