<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
?>
@extends('head_extention_customer') 

@section('content')
    
<head>
    <link href="{{ asset('css/services1.css') }}" rel="stylesheet">
    <title>
        Customer History Page
    </title>
</head>

<body>
<div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
               HISTORY
                </h1> 
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
    <?php
        $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
        $booking_data = Booking::Where('customer_id', $customer_id )->Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->get();
    ?>
    @foreach($booking_data as $key => $value)
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();
    ?>

        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img class="card-img" src="/images/services/general_cleaning.jpg" alt="Card image cap">
                </div>
                <div class="col-md-7">
                        @foreach($service_data as $key => $data)
                        @foreach($price as $key => $price_data)
                        <div class="card-body">
                        <div class="d-flex flex-column">
                            <h5 class="customer_trans_his_status">
                                {{ $value->status }}
                            </h5>
                            <h3 class="customer_trans_his_title">
                                {{ $data->service_name}}
                            </h3>
                            <h6 class="customer_trans_his_date_1_1">
                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                            </h6>
                            <h6 class="customer_trans_his_price_1">
                                P{{ $price_data->price }}
                            </h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link customer_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->service_id }}">
                                    DETAILS
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div> 
                                <div class="modal fade" id="exampleModalLong10-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content p-4 customer_trans_his_modal_content"> <!-- Modal Content -->
                                        <div class="modal-header customer_trans_his_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="customer_trans_his_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="customer_trans_his_modal_title">
                                                    {{ $data->service_name}}
                                                </h4>
                                                <h6 class="customer_trans_his_modal_date_1_1">
                                                    {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                </h6>
                                                <h6 class="customer_trans_his_modal_amount_1">
                                                    Total Amount: P{{ $price_data->price }}
                                                </h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_trans_his_modal_body_1_con">
                                            <p class="customer_trans_his_description">
                                                {{ $data->service_description}}                                            
                                            </p>
                                            <ul class="customer_package_list">
                                                <li>
                                                    <b>Equipment:</b> {{ $data->equipment}}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Materials:</b> {{ $data->material}}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Personal Protection:</b> {{ $data->personal_protection}}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Property Type:</b> {{ $value->property_type}}
                                                </li>    
                                                <?php
                                                    $id = Assigned_cleaner::Where('booking_id', $value->booking_id )->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                                ?>
                                                <br>    
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
                                        </div>
                                        </div>
                                        <div class="modal-footer customer_trans_his_modal_footer">
                                            
                                        </div>
                                    </div> <!-- End of Modal Content -->   
                                    </div>
                                </div> <!-- End of Modal -->
                         

    </div>
    @endforeach
    @endforeach
    @endforeach
</div>
</body>
@endsection

