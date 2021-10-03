<?php
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Booking;
    use App\Models\Service_review;
?>

@extends('head_extention_customer') 

@section('content')
<head>
    <link href="{{ asset('css/services1.css') }}" rel="stylesheet">
    <title>
        Customer Services Page
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

</head>

<body>

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

    <div class="card mb-3" id="card-lists">
        <div class="row no-gutters">
            <div class="col-md-5">
                <img class="card-img" src="/images/services/general_cleaning.jpg" alt="Card image cap">
            </div>
                    <div class="col-md-7">
                        <?php
                            $price_start = Price::Where('property_type', 'Apartments' )->Where('service_id', $value->service_id )->value('price');
                            $price_end = Price::Where('property_type', 'Medium-Upper Class Residential Areas' )->Where('service_id', $value->service_id )->value('price');
                        ?>
                        <div class="card-body">
                            <h2 class="card-title service_title">
                                {{ $value->service_name }}
                            </h2>
                           
                            <h5 class="card-text">
                                Price starts at P{{ $price_start }}
                            </h5>
                            <br>
                            <div class="col-md-6">
                                    <div class="byt float-right">
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->service_id }}">Details</a>
                                    </div>
                            </div>
                        </div>
                    </div>
        </div>           
                       
                        <div class="modal fade" id="exampleModalLong10-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                                <div class="modal-content p-4 customer_services_modal_content"> <!-- Modal Content -->
                                    <div class="modal-header customer_services_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="customer_services_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
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
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_services_modal_body_1_con">
                                            <p class="customer_services_description">
                                                {{ $value->service_description }} 
                                            </p>
                                                <ul class="customer_package_list">
                                                    <li>
                                                        <b>Equipment: </b>{{ $value->equipment }}
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Materials: </b>{{ $value->material }}
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Personal Protection:</b> {{ $value->personal_protection }}
                                                    </li>
                                                    <br>
                                                </ul>
                                            </div>
                                            
                                            <?php
                                                $price_data = Price::Where('service_id', $value->service_id )->get();
                                            ?>
                                            
                                            <div class="d-flex flex-column modal_body_2_con">
                                                <ul class="customer_package_list customer_property_list">
                                                    @foreach($price_data as $key => $data)
                                                        <li>
                                                            <b>{{ $data->property_type }}</b>
                                                        </li>
                                                        <li>
                                                            Price: <b>{{ $data->price }}</b>
                                                        </li>
                                                        <li>
                                                            Cleaners: <b>{{ $data->number_of_cleaner }}</b>
                                                        </li>
                                                        <br>
                                                    @endforeach
                                                </ul> 
                                            </div> 
                                        </div>
                                        <div class="modal-footer customer_services_modal_footer">
                                        @if($LoggedUserInfo['account_status'] == "Verified")
                                            <button type="button" class="btn btn-block btn-primary book_now_btn" data-toggle="modal" data-target="#exampleModalLong101-{{ $value->service_id }}" >
                                                BOOK NOW
                                            </button>
                                            @endif
                                            <div class="modal fade" id="exampleModalLong101-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content customer_services_modal_content_inside"> <!-- Modal Content -->
                                                        <div class="modal-header customer_services_modal_header_inside">
                                                            <div class="p-3 customer_services_modal_inside_con">
                                                                <h3 class="customer_services_modal_title">
                                                                    {{ $value->service_name }}
                                                                </h3>
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
                                                                    <br>
                                                                    <h6> Property Type </h6>
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
                                                                    <label for="appt">
                                                                        Date:
                                                                    </label>
                                                                    <input type="date" name="schedule_date" class="form-control" placeholder="" required readonly>
                                                                    <label for="appt">
                                                                        Time:
                                                                    </label>
                                                                        <input type="time" min="08:00" max="17:00" id="schedule_time" class="form-control" name="schedule_time" >
                                                                    <br>
                                                                    <h6> Payment Option </h6>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                        <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="On-site">
                                                                            On-site
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                        <input type="radio" class="form-check-input" name="mode_of_payment" id="" value="Paypal" >
                                                                            Paypal 
                                                                        </label>
                                                                    </div>
                                                                        <div class="d-flex cancel_confirm_con">
                                                                        <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> 
                                                                            Cancel 
                                                                        </button>
                                                                        <button  type="submit" class="btn btn-block btn-primary confirm_btn"> 
                                                                            Confirm 
                                                                        </button>
                                                                    </div>
                                                                </form>    

                                                            </div>
                                                        </div>
                                                    </div> <!-- End of Modal Content -->
                                                </div>
                                            </div> <!-- End of Modal -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
    @endforeach
    </div>
     <?php
        $scheduledate = Booking::where('status', 'Pending')->orWhere('status', 'Accepted')->orWhere('status', 'On-Progress')->orWhere('status', 'Done')->get();
        $items = array();
        $count = 0;
 ?>
    @if ($scheduledate != null)
    @foreach($scheduledate as $schedule)
    <?php
       
        $schedulueCount = Booking::where('schedule_date', $schedule->schedule_date )->count();
        if($schedulueCount >= 2){
            $items[$count++] = $schedule->schedule_date;
        }
        
    ?>
    @endforeach
    <script>

        var array = <?php echo json_encode($items); ?>;

    $(function () {
    $('input[name="schedule_date"]').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function(schedule_date) {
        var string = jQuery.datepicker.formatDate('yy-mm-dd', schedule_date);
        return [array.indexOf(string) == -1]
        }
    });
    });
    </script>
        @endif

</body>
@endsection



                                                                                                    