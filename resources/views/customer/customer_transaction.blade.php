<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Address;
    use App\Models\Review;
?>

@extends('customer/customer-nav/head_extention_customer-transactions')

@section('content')

<head>
    <link href="{{ asset('css/customer_trans.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet"/>
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
    <div class="body">
        <div class="row justify-content-center" id="status">
            <!-- Count active transaction and completed, declined, and cancelled transaction -->
            <?php
                $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
                $customerCount = Booking::Where('customer_id', $customer_id )->count();
                $booking_data = Booking::Where('customer_id', $customer_id )->Where('status','!=', 'Declined' )->Where('status', '!=','Completed')->Where('status', '!=','Cancelled')->orderBy('updated_at','DESC')->get();
            ?>
            <!-- Display when no transaction -->
            @if($customerCount == 0)
            <div class="banner-container">
                <div class="banner">
                    <div class="text">
                        <h1> You currently have no transaction.</h1>
                    </div>
                    <div class="image">
                        <img src="/images/services/header_img.png" class="img-fluid">
                    </div>
                </div>
            </div>
            @endif
            @if($booking_data !=null)
            @foreach($booking_data as $key => $value)
                <!-- Get transaction details -->
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
                            <!-- Check if the customer already review booking -->
                            <?php
                                $reviews = Review::Where('booking_id', '=', $value->booking_id)->count();
                            ?>
                            <div class="buttons">
                                <div class="byt float-right">
                                    <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                                        DETAILS
                                    </button>
                                    <!-- Show if status is pending and mode of payment is paypal and not yet paid -->
                                    @if($value->status == "Pending" && ($value->mode_of_payment == 'Paypal' && $value->is_paid == false))
                                    <button type="button" class="btn btn-primary pay_btn" onclick="document.location='{{ route('customer_pay', $value->booking_id) }}'">
                                        Pay
                                    </button>
                                    @endif
                                    @if($value->status == "Pending" && ($value->mode_of_payment == 'G-cash' && $value->is_paid == false))
                                    <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#gcash-{{ $value->booking_id }}">
                                        Pay
                                    </button>
                                    @endif
                                    <!-- Show if the status is done and not yet submit rating -->
                                    @if($value->status == "Done" && $reviews == 0 )           
                                    <button type="button" class="btn btn-primary rate_btn" onclick="document.location='{{ route('customer_rating', $value->booking_id) }}'">
                                        Rate
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Service Details -->
                    <div class="modal fade modal-cont" id="gcash" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                                    <div class="modal-content customer_services_modal_content">
                                        <div class="modal-header customer_services_modal_header">
                                            <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                                            <div>
                                                <button type="button" class="close-mobile" data-dismiss="modal">
                                                    <i class="fas fa-arrow-to-left"></i>Back
                                                </button>
                                                <h4 class="modal_customer_services_title">
                                                    {{ $data->service_name}}
                                                </h4>
                                                <h6 class="customer_services_sub_1">
                                                    Gcash Payment
                                                </h6>

                                            </div>
                                        </div>
                                        <div class="modal-body">
                                        <form action="{{ route('gcash') }}" method="post" >
                                    @if(Session::get('success'))
                                    <script>
                                        swal({
                                            title: "Payment Successful!",
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
                                    <input type="hidden" name="booking_id" value="{{$value->booking_id}}">
                                            <div class="gcashqr">
                                                <h6>Scan the QR Code below using your GCash App</h6>
                                                <img src="/images/gcashqr.png" class="img-gcash">
                                            </div>
                                            <div class="customer_services_modal_body_1_con">
                                                <h5>Amount:</h5>
                                                <input type="text" class="form-control input" name="amount" placeholder="₱{{ $price_data->price }}" value="{{ $price_data->price }}" readonly>
                                                
                                            </div>
                                            <div class="customer_services_modal_body_1_con">
                                                <h5>Transaction ID:</h5>
                                                <p>Please input the Transaction ID of the GCash Payment Below</p>
                                                <input type="text" class="form-control input" name="full_name" placeholder="Transaction ID" value="">
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer customer_services_modal_footer">
                                            <button type="submit" class="btn btn-block btn-primary book_now_btn">
                                                CONFIRM
                                            </button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                    <!-- Modal for details -->
                    <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content p-4 customer_trans_modal_content">
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
                                            <li>
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
                                            <!-- Get assigned cleaner/s -->
                                            <?php
                                                $id = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                            ?>
                                            <br>
                                            <li>
                                                <b>Cleaners:</b>
                                            </li>
                                            @if($id != null)
                                            @foreach($id as $cleaner)
                                            <?php
                                                $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id)->value('user_id');
                                                $full = User::Where('user_id', $user_id)->value('full_name');
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
                                    <!-- Show if the status not equal to On-Progress and done -->
                                    @if($value->status != "On-Progress" && $value->status != "Done")
                                    <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-dismiss="modal" data-toggle="modal" data-target="#canceltransaction-{{ $value->booking_id }}">
                                        CANCEL
                                    </button>
                                    @endif
                                    <!-- Show if the status is Pending -->
                                    @if($value->status == "Pending")
                                    <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-dismiss="modal" data-toggle="modal" data-target="#addresses-{{$value->booking_id}}">
                                        CHANGE ADDRESS
                                    </button>
                                    @endif
                                    <!-- Show if the status is No Available Cleaner -->
                                    @if($value->status == "No-Available-Cleaner") 
                                        <button type="button" class="btn btn-block btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#nocleaner-{{ $value->booking_id }}" >
                                            CHOOSE NEW SCHEDULE
                                        </button>
                                    @endif
                                </div>
                            </div> 
                        </div>
                    </div>

                    <!-- Modal for Cancel transaction -->
                    <div class="modal fade" id="canceltransaction-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_trans_modal_content_inside">
                                <div class="modal-header customer_trans_modal_header_inside">
                                    <div class="p-3 customer_trans_modal_inside_con">
                                        <div class="modal-body">
                                            <!-- Form to update booking status-->
                                            <form action="{{ route('updateStatus') }}" method="post">
                                                @if(Session::get('success'))
                                                <script>
                                                    swal({
                                                        title: "Transaction Status Updated Successfully!",
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
                                                <h3 class="cancel_booking_question">
                                                    Are you sure you want to cancel your booking?
                                                </h3>
                                                <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                            <button type="submit"  name="status" value="Cancelled" class="btn btn-primary">YES</button>
                                        </div>
                                            </form>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                            </div> 
                        </div>
                    </div> 
                    <!-- Get address data -->                                    
                    <?php 
                        $addressData = Address::Where('customer_id', $value->customer_id )->get();
                    ?>
                    <!-- Modal for Updating address in booking -->
                    <div class="modal fade" id="addresses-{{$value->booking_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content">
                                <div class="modal-header customer_services_modal_header">
                                    <div class="d-flex">
                                        <h4 class="modal_customer_services_title">
                                            Property Address
                                        </h4>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for updating address for booking -->
                                    <form action="{{ route('updateAddress') }}" method="post" id="book">
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
                                        <input type="hidden" name="booking_id" value="{{$value->booking_id}}">    
                                        @foreach($addressData as $key => $add)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="address" value="{{$add->address_id}}" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <h5>{{$add->address}}</h5>
                                            </label>
                                        </div>
                                        @endforeach
                                </div>
                                <div class="modal-footer customer_services_modal_footer">
                                    <button class="btn btn-block btn-primary confirm_btn" data-toggle="modal" data-target="#addAddress-{{$value->booking_id}}" data-dismiss="modal">
                                            Add New Address
                                    </button>
                                    <button type="submit" class="btn btn-block btn-success ">
                                        Apply
                                    </button>
                                    <button type="button" class="btn btn-block btn-danger cancel_btn" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Add address -->
                    <div class="modal fade" id="addAddress-{{$value->booking_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content customer_services_modal_content">
                                <div class="modal-header customer_services_modal_header">
                                    <div class="d-flex">
                                        <h4 class="modal_customer_services_title">
                                            Add Address
                                        </h4>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for adding address -->
                                    <form action="{{ route('addAddress') }}" method="post" id="book">
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
                                        <input type="hidden" name="customer_id" value="{{$value->customer_id}}">           
                                        <div class="form-group">
                                            <input type="text" class="form-control w-100 add_service_form" id="address" name="address" placeholder="Address" value="{{ old('address') }}">
                                            <span class="text-danger">@error('address'){{ $message }} @enderror</span>
                                        </div>
                                </div>
                                <div class="modal-footer customer_services_modal_footer">
                                    <button type="submit" class="btn btn-block btn-primary confirm_btn">
                                        ADD
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                <!-- Modal for Updating new schedule date and time -->    
                <div class="modal fade" id="nocleaner-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sorry for the Inconvenience</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('newDate') }}" method="post" >
                                    @if(Session::get('success-date'))
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
                                
                                   
                                    <h5> There is no cleaner available for your booking on 
                                        {{ date('F d, Y', strtotime($value->schedule_date)) }} at {{ date('h:i A', strtotime($value->schedule_time)) }} 
                                        with the Booking number {{$value->booking_id}}. </h5>
                                    <h5> Please select a different date and time. </h5> 
                                    <h5> Thank you! </h5> 
                                    <br>
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
                                    CONFIRM NEW SCHEDULE
                                </button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
        </div>
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
        if($scheduleCount == 5){
            $items[$count++] = $schedule->schedule_date . ' ' . $schedule->schedule_time;
        }
    ?>
    @endforeach
    <!-- Disable same schedule date and time have five bookings -->
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

    <!-- Popup when adding address successful -->
    @if(Session::has('success-add'))
    <script>
        swal({
            title: "Added Address Successfully!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    @if(Session::has('success-date'))
    <script>
        swal({
            title: "Schedule time and date Updated!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when updating address successful -->
    @if(Session::has('success-address'))
    <script>
        swal({
            title: "Address Successfully Updated!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when cancel booking successful -->
    @if(Session::has('success-decline'))
    <script>
        swal({
            title: "Successfully Cancel Transaction!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when status updated successful -->
    @if(Session::has('success'))
    <script>
        swal({
            title: "Transaction Status Updated Successfully!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when error occur -->
    @if(session('fail'))
    <script>
        swal({
            title: "Something went wrong, try again!",
            icon: "error",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when rating successful -->
    @if(session('success-rate'))
    <script>
        swal({
            title: "Thank You for your Feedback!",
            text: "Your feedback help us improve our service. Thank You for trusting Sweep.",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when payment successful -->
    @if(session('success-pay'))
    <script>
        swal({
            title: "Payment Successful!",
            icon: "success",
            button: "Close",
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
