<?php
use App\Models\Service;
use App\Models\Price;
use App\Models\Booking;
use App\Models\Service_review;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="{{ asset('js/sweep.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.gonoogleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/customer_services.css') }}" rel="stylesheet">
    <link href="{{ asset('css/popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_welcome.css') }}" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg sticky-top navbar-light sweep-nav shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brandname" href="{{ url('/customer/customer_dashboard') }}">
                SWEEP
            </a>
            <!-- Notification -->
            <ul class="navbar-nav mx-auto">
                <a id="home" class="nav-link active" href="/" role="button">Home</a>
                <a id="services" class="nav-link" href="services" role="button">Services</a>
                <a id="jobs" class="nav-link" href="jobs" role="button">Jobs</a>
                <a id="about_us" class="nav-link" href="about_us" role="button">About Us</a>
                <a id="contact_us" class="nav-link" href="contact_us" role="button">Contact Us</a>
            </ul>
            <ul class="navbar-nav login-web d-flex">
                <!-- Authentication Links -->
                @if (Route::has('customer.customer_login'))
                <a class="btn login_btn-top" href="{{ route('customer.customer_login') }}">{{ __('Login') }}</a>
                @endif
            </ul>
            <!-- Mobile -->
            <ul class="mobile-nav sticky-bottom">
                <a class="nav-button active" href="{{ url('/') }}">
                    <i class="fas fa-home"></i>
                    <h6>Home</h6>
                </a>
                <a class="nav-button" href="{{ url('/cleaning') }}">
                    <i class="fas fa-hand-sparkles fas-active"></i>
                    <h6>Services</h6>
                </a>
            </ul>
        </div>
    </nav>
    <div class="mobile-bg">
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
                                    <h4 class="starts1">Starts for as low as </h4>
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
                                            $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                                            $reviewscount = Service_review::where('service_id', $value->service_id)->count();
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
                                            <a href="reviews/{{$value->service_id}}" role="button">( {{$reviewscount}} Reviews )</a>
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
                                
                                <div class="modal-footer customer_services_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary book_now_btn" data-dismiss="modal" data-toggle="modal" data-target="#book-{{ $value->service_id }}">
                                        BOOK NOW
                                    </button>
                                </div>
                               
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
                                <form action="{{ route('customer.customer_login') }}" method="get" id="book">
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
                                                <button type="submit" class="btn btn-primary confirm_btn" >
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
    $scheduledate = Booking::where('status', 'Pending')->orWhere('status', 'Accepted')->orWhere('status', 'In-Progress')->orWhere('status', 'Done')->get();
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
    </div>
</body>