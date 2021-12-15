<?php

use App\Models\Service;
use App\Models\Price;
use App\Models\Booking;
use App\Models\Service_review;
?>

@extends('customer/customer-nav/head_extention_customer-services')

@section('content')

<head>
    <link href="{{ asset('css/customer_services.css') }}" rel="stylesheet">
    <link href="{{ asset('css/popup.css') }}" rel="stylesheet">
    <title>
        Customer Services Page
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    </div>
    <!-- Get all sweep services -->
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
                        <p class="description">
                            {{ \Illuminate\Support\Str::limit($value->service_description, 120, $end='...') }}
                        </p>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <div class="pricing">
                                    <h4 class="starts">Starts for as low as </h4>
                                    <div class="row pricing">
                                        <div class="col-md-6 col-sm-6 price1">
                                            <h3 class="price">
                                                ₱{{ $price_start }}
                                            </h3>
                                        </div>
                                        <div class="col-md-6 col-sm-6 book">
                                            <div class="byt float-right">
                                                <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#service-{{ $value->service_id }}">
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
                    <!-- Modal Service Details -->
                    <div class="modal fade modal-cont" id="service-{{ $value->service_id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content">
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
                                            Price starts at ₱{{ $price_start }} - ₱{{ $price_end }}
                                        </h6>
                                        <div>
                                            <!-- Service Rating -->
                                            <?php
                                            $reviewscount = Service_review::where('service_id', $value->service_id)->count();
                                            $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                                            $avg = (int)$total;
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($avg >= $i) {
                                                    echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                } else {
                                                    echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                }
                                            }
                                            echo '</span>';
                                            ?>
                                            <a href="customer_reviews/{{$value->service_id}}" role="button" style="font-weight:bold;">( {{$reviewscount}} Reviews )</a>
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
                                        <!-- Service Pricing  -->
                                        <div class="col-md-6">
                                            <?php
                                            $price_data = Price::Where('service_id', $value->service_id)->get();
                                            ?>
                                            <div class="d-flex flex-column modal_body_2_con">
                                                <ul class="customer_package_pricing">
                                                    @foreach($price_data as $key => $data)
                                                    <b>{{ $data->property_type }}</b>
                                                    <br>
                                                    <b>Price:</b> ₱{{ $data->price }}
                                                    <br>
                                                    <b>Cleaners:</b> {{ $data->number_of_cleaner }}
                                                    <br>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Check if customer account is validated -->
                                @if($LoggedUserInfo['account_status'] == "Validated")
                                <div class="modal-footer customer_services_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary book_now_btn" data-dismiss="modal" data-toggle="modal" data-target="#book-{{ $value->service_id }}">
                                        BOOK NOW
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal for booking -->
                    <div class="modal fade modal-cont" id="book-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content_inside">
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
                                <!-- Form for booking -->
                                <form action="{{ route('book') }}" method="post" id="book">
                                    @if(Session::get('success'))
                                    <script>
                                        swal({
                                            title: "Booking Success!",
                                            text: "Thank You For Booking. We will notify you for updates regarding the details of your transaction.",
                                            icon: "success",
                                            button: "Close",
                                        });
                                    </script>
                                    @endif

                                    @if(Session::get('fail'))
                                    <script>
                                        swal({
                                            title: "Something went wrong, try again!",
                                            icon: "error",
                                            button: "Close",
                                        });
                                    </script>
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
                                                <h4 class="place-type"> Payment Option </h4>
                                                <div class="place">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="On-site" checked>
                                                            On-site
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="Paypal">
                                                            Paypal
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="G-cash">
                                                            G-cash
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="place-type"> Schedule: </h4>
                                                <div class="place">
                                                    <label for="appt">
                                                        Date:
                                                    </label>
                                                    <input type="text" name="schedule_date" class="datepickerListAppointments form-control" required>
                                                    <br>
                                                    <label for="appt">
                                                        Time:
                                                    </label>
                                                    <input class="timepicker form-control" type="text" name="schedule_time" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer customer_services_modal_footer sticky-bottom">
                                            <div class="byt float-right">
                                                <button type="button" class="btn btn-danger cancel_btn" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary confirm_btn">
                                                    Confirm
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    </div>

    <!-- Get all active booking   -->
    <?php
    $scheduledate = Booking::where('status', 'Pending')->orWhere('status', 'Accepted')->orWhere('status', 'On-Progress')->orWhere('status', 'Done')->get();
    $items = array();
    $count = 0;
    ?>
    @if ($scheduledate != null)
    @foreach($scheduledate as $schedule)
    <!-- Check Schedule date and time -->
    <?php
    $scheduleCount = Booking::where('schedule_date', $schedule->schedule_date)->Where('schedule_time', $schedule->schedule_time)->count();
    if ($scheduleCount == 2) {
        $items[$count++] = $schedule->schedule_date . ' ' . $schedule->schedule_time;
    }
    ?>
    @endforeach
    <!-- Disable same schedule date and time have five bookings -->
    <script>
        var fakeDisabledTimes = <?php echo json_encode($items); ?>;
        $(document).ready(function() {
            $(".datepickerListAppointments").datepicker({
                minDate: +1,
                onSelect: function(dateText) {
                    //should disable/enable timepicker times from here!
                    // parse selected date into moment object
                    var selDate = moment(dateText, 'MM/DD/YYYY');
                    // init array of disabled times
                    var disabledTimes = [];
                    // for each appoinment returned by the server
                    for (var i = 0; i < fakeDisabledTimes.length; i++) {
                        // parse appoinment datetime into moment object
                        var m = moment(fakeDisabledTimes[i]);
                        // check if appointment is in the selected day
                        if (selDate.isSame(m, 'day')) {
                            // create a 30 minutes range of disabled time
                            var entry = [
                                m.format('h:mm a'),
                                m.clone().add(90, 'm').format('h:mm a')
                            ];
                            // add the range to disabled times array
                            disabledTimes.push(entry);
                        }
                    }
                    // dinamically update disableTimeRanges option
                    $('input.timepicker').timepicker('option', 'disableTimeRanges', disabledTimes);
                }
            });
            $('input.timepicker').timepicker({
                timeFormat: 'h:i a',
                interval: 90,
                minTime: '9',
                maxTime: '4:00pm',
                defaultTime: '9',
                startTime: '9:00',
                dynamic: false,
                dropdown: true,
                scrollbar: false
            });
        });
    </script>
    @endif

    <!-- Mobile -->
    <div class="mobile-spacer">
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </div>
</body>
@endsection