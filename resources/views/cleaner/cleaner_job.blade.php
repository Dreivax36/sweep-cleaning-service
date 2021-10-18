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
<link href="{{ asset('css/cleaner_job.css') }}" rel="stylesheet">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<body>
    <div class="jobs">
        <h1 class="cleaner_cards_title">
            Jobs
        </h1>
    </div>
    <div class="body">
    <div class="row justify-content-center" id="status">
        <?php
        $cleanerID = Cleaner::Where('user_id', $LoggedUserInfo['user_id'])->value('cleaner_id');
        $cleanerCount = Assigned_cleaner::Where('cleaner_id', $cleanerID)->count();
        $bookingID = Assigned_cleaner::Where('cleaner_id', $cleanerID)->Where('status', '!=', 'Declined')->orderBy('updated_at','DESC')->get();
        ?>
        @if($cleanerCount == 0)
        <div class="banner-container">
            <div class="banner1">
                <div class="text">
                    <h1> You currently have no job.</h1>
                </div>
                <div class="image">
                    <img src="/images/services/header_img.png" class="img-fluid">
                </div>

            </div>
        </div>
        @endif
        @if($bookingID != null)
        @foreach($bookingID as $key => $booking)
        <?php
            $booking_data = Booking::Where('status', 'Pending' )->orWhere('status', 'Accepted' )->orWhere('status', 'Done' )->orWhere('status', 'On-Progress' )->orWhere('status', 'On-the-Way')->orderBy('updated_at','DESC')->get();
        ?>
        @foreach($booking_data as $key => $value)
        @if($booking->booking_id == $value->booking_id)
        <?php
        $booking_id = Booking::where('booking_id', $booking->booking_id)->value('booking_id');
        $service_name = Service::Where('service_id', $value->service_id)->value('service_name');
        $userID = Customer::Where('customer_id', $value->customer_id)->value('user_id');
        $user_data = User::Where('user_id', $userID)->get();
        $address = Address::Where('customer_id', $value->customer_id)->value('address');
        $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->get();
        ?>

        <div class="card job" style="width: 25rem;">
            <div class="card-body">
                <h5 class="cleaner_job_status float-right">
                    {{ $value->status }}
                </h5>
                <div class="d-flex card_body">
                    <i class="fas fa-clipboard-list"></i>
                    <h3 class="service_title_trans">
                        {{ $service_name }}
                    </h3>
                </div>
                <div>
                    <h6 class="booking_date">
                        <b>Transaction ID:</b> {{ $booking_id }}
                    </h6>
                </div>
                <table class="table table-striped user_info_table">
                    <tbody>
                        <tr class="user_table_row">
                            @foreach($user_data as $key => $user)
                            <th scope="row" class="user_table_header">
                                Customer:
                            </th>
                            <td class="user_table_data">
                                {{ $user->full_name }}
                            </td>
                            @endforeach
                        </tr>
                        <tr class="user_table_row">
                            <th scope="row" class="user_table_header">
                                Schedule:
                            </th>
                            <td class="user_table_data">
                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                            </td>
                        </tr>
                        <tr class="user_table_row">
                            <th scope="row" class="user_table_header">
                                Property:
                            </th>
                            <td class="user_table_data">
                                {{ $value->property_type}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="buttons">
                    <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                        View Details
                    </button>
                </div>
            </div>
        </div>
        @foreach($price as $key => $price_data)
        <div class="modal-footer customer_services_modal_footer">
            <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <!-- Modal -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-4 cleaner_job_modal_content">
                        <div class="modal-header cleaner_job_modal_header">
                            <div class="d-flex pt-5">
                            <img src="/img/broom.png" class="cleaner_trans_broom_2_1_img p-1">
                                <div class="d-flex flex-column">
                                    <h4 class="cleaner_job_modal_title">
                                        {{ $service_name}}
                                    </h4>
                                    <h6 class="cleaner_job_modal_date_1_1">
                                        {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                    </h6>
                                    <h6 class="cleaner_job_modal_amount_1">
                                        Total Amount: ₱{{ $price_data->price }}
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
                            </ul>
                        </div>

                        @endforeach
                        <form action="{{ route('cleaner') }}" method="post" id="cleaner">
                            <!-- Modal Content-->
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
                                $otwcount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('cleaner_id', '=', $cleanerID)->Where('status', '=', "On-the-Way")->count();
                                $onprogresscount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('cleaner_id', '=', $cleanerID)->Where('status', '=', "On-Progress")->count();       
                                $donecount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('cleaner_id', '=', $cleanerID)->Where('status', '=', "Done")->count();  
                                $idcount = Assigned_cleaner::Where('booking_id', '=', $value->booking_id)->Where('status', '=', "Done")->orderBy('cleaner_id', 'ASC')->first();              
                            ?>
                                                
                            <div class="modal-footer cleaner_job_modal_footer">
                            @if($value->status == "Pending" && $statuscount != $price_data->number_of_cleaner)
                                <button  class="btn btn-block btn-primary accept_btn" type="submit" name="status" value="Accepted" >
                                    CONFIRM BOOKING
                                </button> 
                                <button  class="btn btn-block btn-danger decline_btn" data-toggle="modal" data-target="#decline-{{ $value->booking_id }}"  data-dismiss="modal"> 
                                    DECLINE
                                </button> 
                            @endif   
                            @if($value->status == "Accepted" && $otwcount != $price_data->number_of_cleaner)
                                <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-the-Way" >
                                    ON-THE-WAY
                                </button>    
                            @endif  
                            @if($value->status == "On-the-Way" && $onprogresscount != $price_data->number_of_cleaner)
                                <button  class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-Progress" >
                                    START CLEANING
                                </button>    
                            @endif   
                            @if($value->status == "On-Progress" && $donecount != $price_data->number_of_cleaner)
                                <button class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Done" >
                                    CLEANING COMPLETE
                                </button> 
                            @endif 
                            @if($value->status == "Done" && $value->mode_of_payment == "On-site" && $idcount['cleaner_id'] == $cleanerID)
                            <button type="button" class="btn btn-block btn-primary on_progress_btn" data-toggle="modal" data-dismiss="modal" data-target="#pay-{{ $value->booking_id }}">
                                PAY
                            </button>
                            @endif   
                        </div> 
                        </form>
                    </div><!-- End of Modal Content -->
                </div>
            </div>
        </div><!-- End of Modal -->
                        <div class="modal fade" id="decline-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Decline</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('cleaner') }}" method="post">
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
                                        Are you sure you want to decline this job?
                                        <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                        <input type="hidden" name="cleaner_id" value="{{ $cleanerID }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                        <button type="submit" class="btn btn-danger" name="status" value="Declined">YES</button>
                                    </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                            <div class="modal fade" id="pay-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">On Site Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('onsitePayment') }}" method="post" >
                                    @if(Session::get('success-cleaner'))
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
                                    
                                    <div class="form-group">
                                        <input type="number" class="form-control w-100 add_service_form" id="amount" name="amount" placeholder="Amount" value="{{ old('amount') }}">
                                        <span class="text-danger">@error('amount'){{ $message }} @enderror</span>
                                    </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-block btn-danger no_btn" data-dismiss="modal"> 
                                            CANCEL
                                        </button>
                                        <button type="submit" class="btn btn-block btn-primary yes_btn" > 
                                            PAY
                                        </button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                            </div>   
                            
        @endif
        @endforeach
        @endforeach
        @endif
    </div>
    </div>
    

    @if(!empty(Session::get('success-decline')))
    <script>
        swal({
            title: "Successfully Declined Job!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    @if(!empty(Session::get('success')))
    <script>
        swal({
            title: "Transaction Status Updated Successfully!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    @if(!empty(Session::get('success-cleaner')))
    <script>
        swal({
            title: "On-site Payment Successful!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    @if(!empty(Session::get('fail')))
    <script>
        swal({
            title: "Something went wrong, try again!",
            icon: "error",
            button: "Close",
        });
    </script>
    @endif

    <div class="mobile-spacer">

    </div>
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>
@endsection
