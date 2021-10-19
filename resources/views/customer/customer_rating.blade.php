<?php
    use App\Models\Service;
    use App\Models\Booking;
    use App\Models\Assigned_cleaner;
    use App\Models\User;
    use App\Models\Cleaner;
    use Illuminate\Http\Request;
?>

@extends('customer/customer-nav/head_extention_customer-transactions')

@section('content')

<head>
    <link href="{{ asset('css/customer_service-rate.css') }}" rel="stylesheet">
    <title>
        Customer Services Page
    </title>
</head>

<body>
    <!-- Get details of booking -->
    <?php
        $booking = Booking::where('booking_id', $booking_id)->get();
    ?>
    @foreach($booking as $value)
    <?php
        $serviceName = Service::where('service_id', $value->service_id)->value('service_name');
    ?>
     
    <div class="banner">
        <div class="p-4 customer_cards_title">
            <button type="button" class="close-mobile" data-dismiss="modal">
                <i class="fas fa-arrow-to-left"></i>Back
            </button>
            <h3 class="modal_customer_services_title">
                {{$serviceName}}
            </h3>
        </div>
    </div>
    <!-- Form for rating -->
    <form action="{{ route('rate') }}" method="post" id="book" >
        @if(Session::get('success-rate'))
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
        <input type="hidden" name="booking_id" value="{{$booking_id}}">
        <input type="hidden" name="service_id" value="{{$value->service_id}}">
        <!-- Rating for service -->
        <div class="service_title">
            <h4 class="customer_rating_title">
                How was the Service?
            </h4>
            <fieldset class="rating">
                <input type="radio" id="field1_star5" name="service_rate" value="5" /><label class="full" for="field1_star5"></label>
                <input type="radio" id="field1_star4" name="service_rate" value="4" /><label class="full" for="field1_star4"></label>
                <input type="radio" id="field1_star3" name="service_rate" value="3" /><label class="full" for="field1_star3"></label>
                <input type="radio" id="field1_star2" name="service_rate" value="2" /><label class="full" for="field1_star2"></label>
                <input type="radio" id="field1_star1" name="service_rate" value="1" /><label class="full" for="field1_star1"></label>
            </fieldset>
        </div>
        <br>
        <div class="input-div">
            <h5 class="title2">Would you like to share more?</h5>
            <textarea type="text" rows="8" cols="50" class="form-control contact_fields" name="service_comment" placeholder="Message" value="{{ old('message') }}"></textarea>
            <span class="text-danger">
                @error('message'){{ $message }} @enderror
            </span>
        </div>
        <!-- Rating for cleaner/s -->
        <div class="service_title">
            <h4 class="customer_rating_title">
                How was the cleaner/s?
            </h4>
            <?php
                $counter = 0;
                $cleaner = Assigned_cleaner::where('booking_id', $booking_id)->where('status', 'Done')->get();
            ?>
            @foreach($cleaner as $cleaners)
                <?php
                    $userID = Cleaner::where('cleaner_id', $cleaners->cleaner_id)->value('user_id');
                    $fullname = User::where('user_id', $userID)->value('full_name');
                ?>
            <br>
            <h5 class="customer_rating_title">
                {{$fullname}}:
            </h5>
            <input type="hidden" name="cleaner_id[]" value="{{$cleaners->cleaner_id}}">
            <fieldset class="rating">
                <input type="radio" id="cleaner_star1-{{$cleaners->cleaner_id}}" name="cleaner_rate[{{$counter}}]" value="5" /><label class="full" for="cleaner_star1-{{$cleaners->cleaner_id}}"></label>
                <input type="radio" id="cleaner_star2-{{$cleaners->cleaner_id}}" name="cleaner_rate[{{$counter}}]" value="4" /><label class="full" for="cleaner_star2-{{$cleaners->cleaner_id}}"></label>
                <input type="radio" id="cleaner_star3-{{$cleaners->cleaner_id}}" name="cleaner_rate[{{$counter}}]" value="3" /><label class="full" for="cleaner_star3-{{$cleaners->cleaner_id}}"></label>
                <input type="radio" id="cleaner_star4-{{$cleaners->cleaner_id}}" name="cleaner_rate[{{$counter}}]" value="2" /><label class="full" for="cleaner_star4-{{$cleaners->cleaner_id}}"></label>
                <input type="radio" id="cleaner_star5-{{$cleaners->cleaner_id}}" name="cleaner_rate[{{$counter}}]" value="1" /><label class="full" for="cleaner_star5-{{$cleaners->cleaner_id}}"></label>
            </fieldset>
            <br>
            <br>
            <h5>Would you like to share more?</h5>
            <textarea type="text" rows="8" cols="50" class="form-control contact_fields" name="cleaner_comment[]" placeholder="Message" value="{{ old('message') }}"></textarea>
            <span class="text-danger">
                @error('message'){{ $message }} @enderror
            </span>
            <?php $counter++; ?>
            @endforeach
        </div>
        </div>
        <div class="customer_services_modal_footer">
            <button type="submit" class="btn btn-block btn-primary confirm_btn">
                SUBMIT
            </button>
        </div>
    </form>
    @endforeach

    <!-- Rating CSS when click -->
    <script>
        $("label").click(function() {
            $(this).parent().find("label").css({
                "background-color": "#D8D8D8"
            });
            $(this).css({
                "background-color": "#ffe400"
            });
            $(this).nextAll().css({
                "background-color": "#ffe400"
            });
        });
    </script>

    <!-- Mobile -->
   <div class="mobile-spacer"></div>
</body>
@endsection