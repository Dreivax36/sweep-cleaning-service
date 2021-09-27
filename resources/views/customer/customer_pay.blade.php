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
        Customer Transaction Page
    </title>
</head>

<body>

    <div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
                BOOKINGS
                </h1> 
            </div>
        </div>
    </div>
  <div style="margin: auto;
      width: 60%;
      padding: 20px;">
    <h6 class="customer_trans_head">
        <?php 
         $booking = Booking::where('booking_id', $booking_id)->get();
        ?>
        @foreach($booking as $value)
                                                        Receipt
                                                    </h6>
                                                    <h6 class="customer_trans_name">
                                                        Customer: Lyka C. Casilao
                                                    </h6>
                                                    <h6 class="customer_trans_date">
                                                        {{$value->schedule_date}}
                                                    </h6>
                                                    <div class="customer_trans_service_top_con">
                                                        <h6 class="customer_trans_service">
                                                            Light Cleaning
                                                        </h6>
                                                        <h6 class="customer_trans_price">
                                                            P350.00
                                                        </h6>
                                                    </div>
                                                    <div class="customer_trans_service_bottom_con">
                                                        <h6 class="customer_trans_service">
                                                            Total
                                                        </h6>
                                                        <h6 class="customer_trans_price">
                                                            P350.00
                                                        </h6>
                                                    </div>
                                                    <form action="{{ route('customer_payment') }}" method="post">
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
                                                    <h4> Payment Option </h4>
                                                    <input type="hidden" name="booking_id" value="{{$value->booking_id}}">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="On-site Payment">
                                                            On-site Payment
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="Paypal" >
                                                            Paypal 
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3"> PAY </button>
                                                    </form>
                                                    
</div>
@endforeach
</body>
@endsection