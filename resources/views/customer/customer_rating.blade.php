<?php
    use App\Models\Service;
    use App\Models\Booking;
    use App\Models\Assigned_cleaner;
    use App\Models\User;
    use App\Models\Cleaner;
    use Illuminate\Http\Request;
?>

@extends('head_extention_customer') 

@section('content')
<head>
    <link href="{{ asset('css/customer_service-rate.css') }}" rel="stylesheet">
    <title>
        Customer Services Page
    </title>
</head>
<body>
    <?php
        $booking = Booking::where('booking_id', $booking_id)->get();
    ?>
    @foreach($booking as $value)
    <?php
        $serviceName = Service::where('service_id', $value->service_id)->value('service_name');
    ?>
    <div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
                    SERVICE RATING:
                </h1>
                <h6 class="customer_cards_title">
                    {{$serviceName}}
                </h6> 
            </div>
        </div>
    </div>
    <form action="{{ route('rate') }}" method="post" id="book">
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
    <input type="hidden" name="booking_id" value="{{$booking_id}}">
    <input type="hidden" name="service_id" value="{{$value->service_id}}">
    <fieldset class="rating">
			<input type="radio" id="field1_star5" name="service_rate" value="5" /><label class = "full" for="field1_star5" ></label>
								
			<input type="radio" id="field1_star4" name="service_rate" value="4" /><label class = "full" for="field1_star4"></label>
								
			<input type="radio" id="field1_star3" name="service_rate" value="3" /><label class = "full" for="field1_star3"></label>
								
			<input type="radio" id="field1_star2" name="service_rate" value="2" /><label class = "full" for="field1_star2"></label>
								
			<input type="radio" id="field1_star1" name="service_rate" value="1" /><label class = "full" for="field1_star1"></label>
								
	</fieldset>
    <br>
    <div class="input-div">
        <div>
            <h5>Message</h5>
            <textarea type="text" rows="8" cols="50" class="form-control contact_fields" name="service_comment" placeholder="Message" value="{{ old('message') }}"></textarea>
            <span class="text-danger">
                @error('message'){{ $message }} @enderror
            </span>
        </div>
    </div>

    <div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
                    CLEANER RATING:
                </h1> 
                <?php
                $cleaner = Assigned_cleaner::where('booking_id', $booking_id)->where('status', 'Done')->get();
            ?>
            @foreach($cleaner as $cleaners)
            <?php
                $userID = Cleaner::where('cleaner_id', $cleaners->cleaner_id)->value('user_id');
                $fullname = User::where('user_id', $userID)->value('full_name');
            ?>
                <h6 class="customer_cards_title">
                    {{$fullname}}
                </h6>
            </div>
        </div>
    </div>
        <input type="hidden" name="cleaner_id[]" value="{{$cleaners->cleaner_id}}">
        <fieldset class="rating">
			<input type="radio" id="cleaner_star{{$cleaners->cleaner_id}}" name="cleaner_rate" value="5" /><label class = "full" for="cleaner_star{{$cleaners->cleaner_id}}" ></label>
								
			<input type="radio" id="cleaner_star{{$cleaners->cleaner_id}}" name="cleaner_rate" value="4" /><label class = "full" for="cleaner_star{{$cleaners->cleaner_id}}"></label>
								
			<input type="radio" id="cleaner_star{{$cleaners->cleaner_id}}" name="cleaner_rate" value="3" /><label class = "full" for="cleaner_star{{$cleaners->cleaner_id}}"></label>
								
			<input type="radio" id="cleaner_star{{$cleaners->cleaner_id}}" name="cleaner_rate" value="2" /><label class = "full" for="cleaner_star{{$cleaners->cleaner_id}}"></label>
								
			<input type="radio" id="cleaner_star{{$cleaners->cleaner_id}}" name="cleaner_rate" value="1" /><label class = "full" for="cleaner_star{{$cleaners->cleaner_id}}"></label>
								
		</fieldset>
        
    <br>
    <div class="input-div">
        <div>
            <h5>Message</h5>
            <textarea type="text" rows="8" cols="50" class="form-control contact_fields" name="cleaner_comment" placeholder="Message" value="{{ old('message') }}"></textarea>
            <span class="text-danger">
                @error('message'){{ $message }} @enderror
            </span>
        </div>
    </div>
    @endforeach

    <div class="customer_services_modal_footer">
        <button type="submit" class="btn btn-block btn-primary confirm_btn"> 
            SUBMIT
        </button>     
    </div>
</form>
    <div class="mobile-spacer"></div>
    @endforeach

    <script>
        $("label").click(function(){
        $(this).parent().find("label").css({"background-color": "#D8D8D8"});
        $(this).css({"background-color": "#ffe400"});
        $(this).nextAll().css({"background-color": "#ffe400"});
        });
    </script>
</body>
@endsection