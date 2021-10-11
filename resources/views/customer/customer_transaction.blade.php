<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Review;
?>

@extends('customer/customer-nav/head_extention_customer-transactions') 

@section('content')
    
<head>
    <link href="{{ asset('css/customer_trans.css') }}" rel="stylesheet">
    <title>
        Customer Transaction Page
    </title>
    <script
    src="https://code.jquery.com/jquery-3.5.1.js"
    integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous">
    </script>
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
    <div class="row justify-content-center">
        <?php
            $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
            $booking_data = Booking::Where('customer_id', $customer_id )->Where('status','!=', 'Declined' )->Where('status', '!=','Completed')->Where('status', '!=','Cancelled')->orderBy('updated_at','DESC')->get();
        ?>
        @foreach($booking_data as $key => $value)
            <?php
                $booking_id = Booking::where('booking_id', $value->booking_id )->value('booking_id');
                $service_data = Service::Where('service_id', $value->service_id )->get();
                $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();
            ?>
        <div class="card  mb-3" style="width: 25rem;">
            <div class="row no-gutters">
             
                    @foreach($service_data as $key => $data)
                        @foreach($price as $key => $price_data)
                            <div class="card-body"> 
                                <div class="status">
                                    <h5 class="customer_trans_status">
                                        {{ $value->status }}
                                    </h5>
                                </div>
                                <div class="card_body">
                                    <h3 class="service_title_trans">
                                        {{ $data->service_name }}
                                    </h3>
                                </div>
                                <div> 
                                    <h6 class="booking_date">
                                        <b>Transaction ID:</b> {{ $booking_id }}
                                        @if ( $value->is_paid == true)
                                            <b> - Paid </b>
                                        @endif
                                    </h6>
                                </div>
                                
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Schedule:
                                            </th>
                                            <td class="user_table_data">
                                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Property:
                                            </th>
                                            <td class="user_table_data">
                                                {{ $value->property_type}}
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Price:
                                            </th>
                                            <td class="user_table_data">
                                                ₱{{ $price_data->price }}
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <?php
                                    $reviews = Review::Where('booking_id', '=', $value->booking_id)->count();
                                ?>
                                <div class="buttons">
                                    <div class="byt float-right">
                                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->booking_id }}">
                                            DETAILS
                                        </button>
                                        
                                        @if($value->status == "Done" && $reviews != 0 )               
                                        <button type="button" class="btn btn-primary rate_btn" onclick="document.location='{{ route('customer_rating', $value->booking_id) }}'"> 
                                            Rate 
                                        </button>
                                        @endif
                                    </div>
                                </div>
                  </div>
            </div>

            
                        <div class="modal fade" id="exampleModalLong10-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                                <div class="modal-content p-4 customer_trans_modal_content"> <!-- Modal Content -->
                                    <div class="modal-header customer_trans_modal_header">
                                            <img src="/img/broom.png" class="customer_trans_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="customer_trans_modal_title">
                                                    {{ $data->service_name}}
                                                </h4>
                                                <h6 class="customer_trans_modal_date_1_1">
                                                    {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                </h6>
                                                <h6 class="customer_trans_modal_amount_1">
                                                    Total Amount: ₱{{ $price_data->price }}
                                                </h6>
                                            </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_trans_modal_body_1_con">
                                            <p class="customer_trans_description">
                                                {{ $data->service_description}}                                            
                                            </p>
                                            <ul class="customer_package_list">
                                                <li>
                                                    <b>Equipment:</b> {{ $data->equipment }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Materials:</b> {{ $data->material }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Personal Protection:</b> {{ $data->personal_protection }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Property Type:</b> {{ $value->property_type }}
                                                </li> 
                                                <br>
                                               
                                            <li class="list_booking_info">
                                                <b>Mode of Payment:</b> {{ $value->mode_of_payment }}
                                            </li>
                                            <br>
                                            @if ( $value->mode_of_payment == 'Paypal')
                                            <li class="list_booking_info">
                                                <b>Paypal ID:</b> {{ $value->paypal_id }}
                                            </li>
                                            <br>
                                            @endif
                                            @if ( $value->is_paid == true)
                                            <li class="list_booking_info">
                                                <b>Status:</b> Paid
                                            </li>
                                            <br>
                                            @endif
                                            
                                                <?php
                                                     $id = Assigned_cleaner::Where('booking_id', $value->booking_id )->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                                ?>
                                                  
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
                                        
                                        <div class="modal-footer customer_trans_modal_footer">
                                        @if($value->status != "On-Progress" && $value->status != "Done") 
                                            <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-toggle="modal" data-target="#canceltransaction-{{ $value->booking_id }}" >
                                                CANCEL
                                            </button>
                                        @endif
                                        @if($value->status == "Pending" && $value->is_paid == false && $value->mode_of_payment == 'Paypal') 
                                        <!--
                                        <button type="button" class="btn btn-primary pay_btn"  onclick="document.location='{{ route('customer_pay', $value->booking_id) }}'"> 
                                            Pay 
                                        </button> 
                                        <script>
                                            $('#exampleModalLong10-{{ $value->booking_id }}').modal('hide');
                                        </script>-->
                                        <div id="paypal-button-container"></div>
                                        @endif
                                        
                                        @if($value->status == "No-Available-Cleaner") 
                                            <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-toggle="modal" data-target="#nocleaner-{{ $value->booking_id }}" >
                                                CHOOSE NEW SCHEDULE
                                            </button>
                                        @endif
                                        </div>
                                </div> <!-- End of Modal Content --> 
                            </div>
                        </div> <!-- End of Modal -->
                                            <div class="modal fade" id="canceltransaction-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content customer_trans_modal_content_inside"> <!-- Modal Content -->
                                                        <div class="modal-header customer_trans_modal_header_inside">
                                                            <div class="p-3 customer_trans_modal_inside_con">
                                                                <h3 class="cancel_booking_question">
                                                                    Are you sure you want to cancel your booking?
                                                                </h3>
                                                                <form action="{{ route('updateStatus') }}" method="post">
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
                                                                <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                                                   
                                                                <div class="d-flex no_yes_con">
                                                                    <button type="button" class="btn btn-block btn-primary no_btn" data-dismiss="modal"> 
                                                                        NO 
                                                                    </button>
                                                                    <button type="submit" class="btn btn-block btn-primary yes_btn" name="status" value="Cancelled"> 
                                                                        YES 
                                                                    </button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    </div> <!-- End of Modal Content -->
                                                </div>
                                            </div> <!-- End of Modal -->
                                            @if ($value->status == 'No-Available-Cleaner')
                                                <script>
                                                    $('#nocleaner-{{ $value->booking_id }}').modal('show');
                                                </script>
                                            @endif 

            <!-- Modal -->
            <div class="modal fade" id="nocleaner-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">No Cleaner Availble</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('newDate') }}" method="post" >
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
                                    <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                    
                                    <h3> Sorry for the Inconvenience </h3>
                                    <h5> Your Booking that is Schedule for 
                                    {{ date('F d, Y', strtotime($value->schedule_date)) }} at {{ date('h:i A', strtotime($value->schedule_time)) }} 
                                    with the Booking ID - {{$value->booking_id}} is NO CLEANER AVAILABLE. </h5>
                                    <h5> Please choose other date and time. Thank you! </h5> 
                                    <h4 class="place-type"> Schedule: </h4>   
                                    <div class="place"> 
                                    <label for="appt">
                                       Date:
                                    </label>
                                    <input type="text" name="schedule_date" class="datepickerListAppointments form-control">
                                    <br>

                                    <label for="appt" class="place-type">
                                        Time:
                                    </label>
                                    <input class="timepicker form-control" type="text" name="schedule_time" >
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-danger no_btn" data-dismiss="modal"> 
                                            CANCEL
                                        </button>
                                        <button type="submit" class="btn btn-block btn-primary yes_btn" > 
                                            CHOOSE NEW SCHEDULE
                                        </button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                            </div>

                                           
        <script type="text/javascript" src="https://www.paypal.com/sdk/js?client-id=AWIHuW0P8CWfwO_fMMmWkiMa2jEhsI231WVL1ihLTqjY_PQtTlaDcE4lOVP-nL7EeTD0yrcLUxQMuHu0&currency=PHP&locale=en_PH"></script>
        <script>
            paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ $price_data->price }}',
                        currency_code: "PHP"
                    }
                }],
                application_context: {
                     brand_name: 'Sweep',
                    shipping_preference: 'NO_SHIPPING'
                }
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                var booking_id = '{{$value->booking_id}}';
                var amount  = '{{ $price_data->price }}';
                //var CSRF_TOKEN = $
                
                $.ajax({
                    type: 'GET',
                    url: "{{ route('checkout') }}",
                    data: {
                        'booking_id': booking_id,
                        'paypal_id': details.id,
                        'amount': amount,
                        'payment_mode':  'Paypal'
                    },
                    success: function (response) {
                        window.location.href = "{{ url('/customer/customer_transaction') }}";
                    }
                });
                alert("Payment successful");
                });
            },
            onCancel: function(data) {
                alert("Payment cancelled");
            },
            }).render({
            style: {
            size: 'responsive'
            }
            },'#paypal-button-container');
        </script>
       
       @endforeach
             @endforeach
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
        $scheduleCount = Booking::where('schedule_date', $schedule->schedule_date)->Where('schedule_time', $schedule->schedule_time)->count();
        if($scheduleCount == 5){
            $items[$count++] = $schedule->schedule_date . ' ' . $schedule->schedule_time;
        }
    ?>
    @endforeach
        <script >
    var fakeDisabledTimes = <?php echo json_encode($items); ?>;

$(document).ready(function(){
  $( ".datepickerListAppointments" ).datepicker({
    minDate:+1,
    onSelect : function(dateText){
      //should disable/enable timepicker times from here!
      // parse selected date into moment object
      var selDate = moment(dateText, 'MM/DD/YYYY');
      // init array of disabled times
      var disabledTimes = [];
      // for each appoinment returned by the server
      for(var i=0; i<fakeDisabledTimes.length; i++){
        // parse appoinment datetime into moment object
        var m = moment(fakeDisabledTimes[i]);
        // check if appointment is in the selected day
        if( selDate.isSame(m, 'day') ){
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

<div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
</div>
</body>
@endsection