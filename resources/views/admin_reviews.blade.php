<?php
    use App\Models\Notification;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Service_review;
    use App\Models\Review;
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\User;
?>


@extends('head_extention_admin')

@section('content')
<title>
    Admin Services Page
</title>
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_services.css')}}">
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navig.css') }}" rel="stylesheet">

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
                <ul class="navbar-nav ml-auto">
                    <a href="admin_dashboard" class="nav-link"></a>
                    <a class="nav-link" href="admin_services" role="button" id="active"></a>
                    <a class="nav-link" href="admin_transaction" role="button"></a>
                    <a class="nav-link" href="admin_user" role="button"></a>
                    <a class="nav-link" href="admin_payroll" role="button"></a>
                    <a class="nav-link" href="admin_reports" role="button"></a>
                    <!-- Notification -->
                    <li class="nav-item dropdown" id="admin">
                        <?php
                        $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                        $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                        ?>
                        <a id="navbarDropdown admin" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-bell"></i>
                            @if($notifCount != 0)
                            <span class="badge alert-danger pending">{{$notifCount}}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                            @forelse ($notif as $notification)
                            <a class="dropdown-item read" id="refresh" href="/{{$notification->location}}/{{$notification->id}}">
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
                            <a class="dropdown-item" data-dismiss="modal" data-toggle="modal" data-target="#logout">
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
    <?php
        $servicename = Service::where('service_id', $service_id)->value('service_name');
        $price_start = Price::Where('property_type', 'Apartments')->Where('service_id', $service_id)->value('price');
        $price_end = Price::Where('property_type', 'Medium-Upper Class Residential Areas')->Where('service_id', $service_id)->value('price');
    ?>
    <div class="modal-header customer_services_modal_header">

        <div class="p-4">
            <button class="navbar-toggler" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
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
        <h2>Customer Ratings</h2>
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
                <h6>Total Rating: 
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
                <h6>Comments:</h6>
                <p>{{$review->comment}}</p>
            </div>
            @endforeach
        </div>
    </div>

</body>
@endsection