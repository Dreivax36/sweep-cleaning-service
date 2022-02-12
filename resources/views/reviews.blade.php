<?php
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Service_review;
    use App\Models\Review;
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\User;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/customer_services.css') }}" rel="stylesheet">
    <link href="{{ asset('css/popup.css') }}" rel="stylesheet">
    <title>
        Customer Reviews Page
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navig.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-light sweep-nav shadow-sm">
        <div class="container-fluid">
            <button class="navbar-toggler" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <a class="navbar-brandname" href="{{ url('/customer/customer_dashboard') }}">
                SWEEP
            </a>
            <!-- Notification -->
            <ul class="navbar-nav mx-auto">
                <a id="home" class="nav-link active" href="/" role="button">
                    Home
                </a>
                <a id="services" class="nav-link" href="services" role="button">
                    Services</a>
                <a id="jobs" class="nav-link" href="jobs" role="button">
                    Jobs
                </a>
                <a id="about_us" class="nav-link" href="about_us" role="button">
                    About Us
                </a>
                <a id="contact_us" class="nav-link" href="contact_us" role="button">
                    Contact Us
                </a>
            </ul>
            <ul class="navbar-nav login-web d-flex">
                <!-- Authentication Links -->
                @if (Route::has('customer.customer_login'))
                <a class="btn login_btn-top" href="{{ route('customer.customer_login') }}">{{ __('Login') }}</a>
                @endif
            </ul>
        </div>
    </nav>
    <?php
        $servicename = Service::where('service_id', $service_id)->value('service_name');
        $price_start = Price::Where('property_type', 'Apartments')->Where('service_id', $service_id)->value('price');
        $price_end = Price::Where('property_type', 'Medium-Upper Class Residential Areas')->Where('service_id', $service_id)->value('price');
    ?>
    <div class="modal-header customer_services_modal_header">
        <div class="p-4">
            <h4 class="modal_customer_services_title">
                {{$servicename}}
            </h4>
            <h6 class="customer_services_sub_1">
                Price starts at ₱{{ $price_start }} - ₱{{ $price_end }}
            </h6>
            <a class="rating" href="reviews">
                <!-- Service Rating -->
                <i class="fa fa-star" style="color:yellow" aria-hidden="true"></i><i class="fa fa-star" style="color:yellow" aria-hidden="true"></i><i class="fa fa-star" style="color:yellow" aria-hidden="true"></i><i class="fa fa-star" style="color:yellow" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="rating-cont">
        <h2>
            Customer Ratings
        </h2>
        <div class="row justify-content-center">
            <?php
            $reviews = Service_review::where('service_id', $service_id)->get();
            ?>
            @foreach($reviews as $review)
            <div class="card" style="width: 25rem;">
                <?php
                    $bookingid = Review::where('review_id', $review->review_id)->value('booking_id');
                    $customerid = Booking::where('booking_id', $bookingid)->value('customer_id');
                    $user_id = Customer::where('customer_id', $customerid)->value('user_id');
                    $fullname = User::where('user_id', $user_id)->value('full_name');
                ?>
                <h5>{{$fullname}}</h5>
                <h6>
                    Total Rating:
                    <?php
                        $avg = (int)$review->rate;
                        for ($i = 1; $i <= 5; $i++) {
                            if ($avg >= $i) {
                                echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                            } else {
                                echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                            }
                        }
                        echo '</span>';
                    ?>
                </h6>
                <h6>
                    Comments:
                </h6>
                <p>{{$review->comment}}</p>
            </div>
            @endforeach
        </div>
    </div>
</body>