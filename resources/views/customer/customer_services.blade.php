<?php

use App\Models\Service;
use App\Models\Price;
use App\Models\Service_review;

function calendar($month, $year)
{
    $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayWeek = $dateComponents['wday'];
    $datetoday = date('Y-m-d');
    $dateYear = ($year != '') ? $year : date("Y");
    $dateMonth = ($month != '') ? $month : date("m");
    $date = $dateYear . '-' . $dateMonth . '-01';

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<div class='d-flex justify-content-center'>";
    $calendar .= "<a href='javascript:void(0);' class='btn btn-xs btn-primary' onclick='calendar('<?php echo date('Y',strtotime($date.' - 1 Month')); ?>','<?php echo date('m',strtotime($date.' - 1 Month')); ?>');'></a>";
    //$calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous</a>";
    $calendar .= "<h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next</a>";
    $calendar .= "</div>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr><tr>";

    if ($dayWeek > 0) {
        for ($k = 0; $k < $dayWeek; $k++) {
            $calendar .= "<td></td>";
        }
    }
    $currentDay = 1;

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {


        if ($dayWeek == 7) {
            $dayWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? "today" : "";

        if ($date < date('Y-m-d')) {
            $calendar .= "<td class='blocked'><h4>$currentDay</h4>";
        } elseif ($date == date('Y-m-d')) {
            $calendar .= "<td class='today'><h4>$currentDay</h4>";
        } else {
            $calendar .= "<td data-dismiss='modal' data-toggle='modal' data-target='#exampleModalLong1011' class='btn1'><h4>$currentDay</h4>";
        }

        $calendar .= "</td>";
        $currentDay++;
        $dayWeek++;
    }

    if ($dayWeek != 7) {
        $remainingDays = 7 - $dayWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    echo $calendar;
}
?>

@extends('customer/customer-nav/head_extention_customer-services')

@section('content')

<head>
    <link href="{{ asset('css/customer_services.css') }}" rel="stylesheet">
    <title>
        Customer Services Page
    </title>
</head>

<body>
    <div class="banner-container">
        <div class="banner">
            <div class="text">
                <h1>The Road to Cleanliness has never been easier.</h1>
                <p>Making your comfort zones squeaky clean one step at a time.</p>
            </div>
            <div class="image">
                <img src="/images/services/header_img.png" class="img-fluid">
            </div>

        </div>
    </div>
    <div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
                    SERVICES
                </h1> 
            </div>
        </div>
        <div class="col-md-4">
            <div class="customer_search_con"> <!-- Search Field -->
            <input class="form-control searchbar" type="text" id="filter" placeholder="Search.." onkeyup="searchTrans()"> 
            </div> <!-- End of Search Field -->
        </div>
    </div>
   
    <div class="row justify-content-center">
        <?php
        $service_data = Service::all();
        ?>
        @foreach($service_data as $key => $value)
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-5 col-sm-5">
                    <img class="card-img" src="/images/services/general_cleaning.jpg" alt="Card image cap">
                </div>
                <div class="col-md-7 col-sm-7">
                    <?php
                    $price_start = Price::Where('property_type', 'Apartments')->Where('service_id', $value->service_id)->value('price');
                    $price_end = Price::Where('property_type', 'Medium-Upper Class Residential Areas')->Where('service_id', $value->service_id)->value('price');
                    ?>
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ $value->service_name }}
                        </h3>
                        <p>
                        {{ \Illuminate\Support\Str::limit($value->service_description, 100, $end='...') }}
                        </p>   
                        <div class="row">
                            <div class="col">
                                <div class="pricing">
                                    <h4 class="starts">Starts for as low as </h4>
                                    <div class="row pricing">
                                        <div class="col-md-6 col-sm-6 price1">
                                            <h3 class="price">
                                                P{{ $price_start }}
                                            </h3>
                                        </div>
                                        <div class="col-md-6 col-sm-6 book">
                                            <div class="byt float-right">
                                                <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->booking_id }}">
                                                    DETAILS
                                                </button>
                                                <!-- <a class="btn btn-primary" href="{{ url('/customer/book') }}">Book Now</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade modal-cont" id="exampleModalLong10-{{ $value->service_id }}" aria-hidden="true">
                        <!-- Modal -->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content">
                                <!-- Modal Content-->
                                <div class="modal-header customer_services_modal_header">
                                    <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                                    <div class="p-4">
                                        <button type="button" class="close-mobile" data-dismiss="modal">
                                            <i class="fas fa-arrow-to-left"></i>Back
                                        </button>
                                        <h4 class="modal_customer_services_title">
                                            {{ $value->service_name }}
                                        </h4>
                                        <h6 class="customer_services_sub_1">
                                            Price starts at P{{ $price_start }} - P{{ $price_end }}
                                        </h6>
                                        <div>
                                        <?php
                                            $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                                            $avg = (int)$total;
                                                        
                                            for ( $i = 1; $i <= 5; $i++ ) {
                                                if ( $avg >= $i ) {
                                                    echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                } else {
                                                    echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                }
                                            }
                                            echo '</span>';
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="customer_services_modal_body_1_con">
                                                <h4>Service Details:</h4>
                                                <p class="customer_services_description">
                                                    {{ $value->service_description }}
                                                </p>
                                                <ul class="customer_package_list">
                                                    <li>
                                                        <b>Equipment:</b> {{ $value->equipment }}
                                                    </li>

                                                    <li>
                                                        <b>Materials:</b> {{ $value->material }}
                                                    </li>

                                                    <li>
                                                        <b>Personal Protection:</b> {{ $value->personal_protection }}
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            $price_data = Price::Where('service_id', $value->service_id)->get();
                                            ?>
                                            <div class="d-flex flex-column modal_body_2_con">
                                                @foreach($price_data as $key => $data)
                                                <b>{{ $data->property_type }}</b>
                                                <ul class="customer_package_pricing">

                                                    <b>Price:</b> {{ $data->price }}
                                                    <br>
                                                    <b>Cleaners:</b> {{ $data->number_of_cleaner }}

                                                </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer customer_services_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary book_now_btn" data-dismiss="modal" data-toggle="modal" data-target="#exampleModalLong101-{{ $value->service_id }}">
                                        BOOK NOW
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                        </div>
                    </div> <!-- End of Modal -->
                    <div class="modal fade modal-cont" id="exampleModalLong101-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <!-- Modal -->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content_inside">
                                <!-- Modal Content-->
                                <div class="modal-header customer_services_modal_header">
                                    <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                                    <div class="p-4">
                                        <button type="button" class="close-mobile" data-dismiss="modal">
                                            <i class="fas fa-arrow-to-left"></i>Back
                                        </button>
                                        <h3 class="modal_customer_services_title">
                                            {{ $value->service_name }}
                                        </h3>
                                    </div>
                                </div>
                                <form action="{{ route('book') }}" method="post" id="book">
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
                                <input type="hidden" name="user_id" value="{{ $LoggedUserInfo['user_id'] }}">
                                <div class="modal-body p-4 customer_services_modal_inside_con">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="place-type">
                                                What is your Property Type?
                                            </h4>
                                            <div class="place">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="property_type" id="flexRadioDefault1" value="Medium-Upper Class Residential Areas" checked>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Medium-Upper Class Residential Areas
                                                        </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="property_type" id="flexRadioDefault2" value="Apartments">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Apartments
                                                        </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="property_type" id="flexRadioDefault2" value="Condominiums">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Condominiums
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="modal-footer customer_services_modal_footer sticky-bottom">
                                    <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModalLong1011-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <!-- Modal -->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content_inside">
                                <!-- Modal Content-->
                                <div class="modal-header customer_services_modal_header">
                                    <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                                    <div class="p-4">
                                        <button type="button" class="close-mobile" data-dismiss="modal">
                                            <i class="fas fa-arrow-to-left"></i>Back
                                        </button>
                                        <h3 class="modal_customer_services_title">
                                            {{ $value->service_name }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="modal-body p-4 customer_services_modal_inside_con">
                                    <div class="modal-body p-4 customer_services_modal_inside_con">
                                        <div>
                                            <h4 class="date-selected">
                                                October 5, 2021
                                            </h4>
                                        </div>
                                        <h4 class="place-type">
                                            What is your Property Type?
                                        </h4>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                9:00 AM - 10:30 AM
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                10:30 AM - 12:00 NN
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                1:00 PM - 2:30 PM
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                2:30 PM - 4:00 PM
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-body p-4 customer_services_modal_inside_con">
                                        <div>
                                            <h4 class="date-selected">
                                                Choose your Payment Method:
                                            </h4>
                                            <h5>Online Payment</h5>
                                            <h5>On Site Payment</h5>
                                        </div>
                                    </div>
                                    <div class="modal-body p-4 customer_services_modal_inside_con">
                                        <div>
                                            <h4 class="date-selected">
                                                Booking Summary:
                                            </h4>
                                            <h5>Service: Deep Kitchen Cleaning</h5>
                                            <h5>Property: Apartment</h5>
                                            <h5>Schedule: October 03, 2021 | 8:30 AM - 10:00 AM</h5>
                                            <h5>Price: 390 Pesos</h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer customer_services_modal_footer">
                                    <button form="myform" type="submit" class="btn btn-block btn-primary confirm_btn">
                                        CONFIRM
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mobile-spacer">

    </div>
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
</div>
</body>
@endsection