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
    use App\Models\Service_review;
    use App\Models\Cleaner_review;
?>
@extends('head_extention_cleaner') 

@section('content')
    <title>
        Cleaner History Page
    </title>
    <link href="{{ asset('css/style_cleaner.css') }}" rel="stylesheet">
<body>
   
    <div class="col-2 d-flex cleaner_job_title_con">
        <div>
            <h1 class="cleaner_cards_title">
                History 
            </h1> 
        </div>
    </div>
    <?php
        $cleanerID = Cleaner::Where('user_id', $LoggedUserInfo['user_id'])->value('cleaner_id');
        $bookingID = Assigned_cleaner::Where('cleaner_id', $cleanerID)->Where('status', 'Declined')->orWhere('status', 'Done')->get();
    ?>
    <div class="cleaner_job_con">
    @if($bookingID != null)
        @foreach($bookingID as $key => $booking)
        <div class="column col_cleaner_job">
        <div class="row row_cleaner_job">
        
           
        <?php
            $booking_data = Booking::where('booking_id', $booking->booking_id)->orWhere('status', 'Declined' )->orWhere('status', 'Done' )->orWhere('status','Completed' )->get();
        ?>
        @foreach($booking_data as $key => $value)
        @if($booking->booking_id == $value->booking_id)
        <?php
            $service_data = Service::Where('service_id', $value->service_id )->get();
            $user_data = User::Where('user_id', $value->customer_id )->get();
            $address_data = Address::Where('customer_id', $value->customer_id )->get();
            $price = Price::Where('property_type', $value->property_type )-> Where('service_id', $value->service_id )->get();
            $cleaner_data = User::Where('user_type', 'Cleaner' )->get();
        ?>


                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">  
                        <div class="d-flex flex-column">
                            @if ($booking->status != 'Declined')
                            <h5 class="cleaner_job_status">
                                {{ $value->status }}
                            </h5>
                            @else
                            <h5 class="cleaner_job_status">
                                {{ $booking->status }}
                            </h5>
                            @endif
                            @foreach($service_data as $key => $data)
                            <h3 class="cleaner_job_title">
                                {{ $data->service_name}}
                            </h3>
                            <h6 class="cleaner_job_date_1_1">
                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                            </h6>
                             @foreach($price as $key => $price_data)
                            <h6 class="cleaner_job_price_1">
                                P{{ $price_data->price }}
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10-{{$value->booking_id}}">
                                    DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
              
                                @foreach($user_data as $key => $user)
                                @foreach($address_data as $key => $address)
                                <div class="modal fade" id="exampleModalLong10-{{$value->booking_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('updateStatus') }}" method="post" id="myform"> <!-- Modal Content -->
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
                                        
                                            <input type="hidden" name="service_id" value="{{ $value->service_id }}">
                                            <div class="modal-content p-4 cleaner_job_modal_content">
                                                <div class="modal-header cleaner_job_modal_header">
                                                    <div class="d-flex pt-5">
                                                        <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                                        <div class="d-flex flex-column">
                                                            <h4 class="cleaner_job_modal_title">
                                                                {{ $data->service_name }}
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
                                                <div class="modal-body d-flex p-4">
                                                    <div class="cleaner_job_modal_body_1_con">
                                                        <ul class="cleaner_detail">
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
                                                                <b>Address:</b> {{ $address->address }}
                                                            </li>
                                                            <br>
                                                            <li><b>Service Details:</b></li>
                                                            <li class="list_booking_info">
                                                                <b>Property Type:</b> {{ $value->property_type}}</li>
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
                                                                <b>Feedback:</b>
                                                                <h6>Service</h6>
                                                                <?php
                                                                $review_id = Review::where('booking_id', $value->booking_id)->where('review_type', 'Service')->value('review_id');
                                                                if($review_id != null){
                                                                $total = Service_review::where('review_id', $review_id)->value('rate');
                                                                
                                                                for ( $i = 1; $i <= 5; $i++ ) {
                                                                    if ( $total >= $i ) {
                                                                        echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                                    } else {
                                                                        echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                                    }
                                                                }
                                                                echo '</span>';
                                                                $comment = Service_review::where('review_id', $review_id)->value('comment');
                                                                }
                                                                ?>
                                                                <h7>{{$comment}}</h7>
                                                        <h6>Review for you</h6>
                                                            <?php
                                                            $reviewId = Review::where('booking_id', $value->booking_id)->where('review_type', 'Cleaner')->get();
                                                           ?>
                                                            @foreach($reviewId  as $review)
                                                            <?php

                                                            $total = Cleaner_review::where('review_id', $review->review_id)->where('cleaner_id', $cleanerID)->value('rate');
                                                            if($total != null){
                                                            $avg = (int)$total;
                                                        
                                                            for ( $i = 1; $i <= 5; $i++ ) {
                                                                if ( $avg >= $i ) {
                                                                    echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                                } else {
                                                                    echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                                }
                                                            }
                                                            echo '</span>';
                                                            $comment = Cleaner_review::where('review_id', $review->review_id)->where('cleaner_id', $cleanerID)->value('comment');
                                                        }
                                                            ?>
                                                            <h7>{{$comment}}</h7>
                                                            @endforeach          
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!-- End of Modal Content -->
                                    </div>
                                </div> <!-- End of Modal -->
                     
                                
    @endforeach
    @endforeach
    @endforeach
 
    @endforeach
    @endif

    @endforeach
    </div>  
    </div>
    @endforeach
    @endif
    </div>
</body>
@endsection