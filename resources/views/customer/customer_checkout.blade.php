<?php
    use App\Models\Booking;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\Customer;
    use App\Models\User;
?>

@extends('customer/customer-nav/head_extention_customer-transactions')

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/customer_checkout.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>
        Customer Payment Page
    </title>
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
</head>

<body>
    <!-- Get Details of booking -->
    <?php
        $booking = Booking::where('booking_id', $booking_id)->get();
        ?>
        @foreach($booking as $value)
        <?php
        $serviceName = Service::where('service_id', $value->service_id)->value('service_name');
        $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->value('price');
        $userId = Customer::Where('customer_id', $value->customer_id )->value('user_id');
        $user_data = User::Where('user_id', $userId )->get();
        $address = Address::Where('address_id', $value->address_id )->value('address');
    ?>
    <div class="banner">
        <div class="p-4 customer_cards_title">
            <button type="button" class="close-mobile" data-dismiss="modal">
                <i class="fas fa-arrow-to-left"></i>Back
            </button>
        </div>
    </div>
    <!-- Display Details of booking -->
    <div class="row justify-content-center">
        <div class="info">
            <div class="d-flex">
                <h3>
                    <i class="fas fa-map-marker-alt"></i> Customer Information:
                </h3>
            </div>
            @foreach($user_data as $user)
            <div class="customer-details">
                <h4 class="name">
                    {{ $user->full_name }}
                </h4>
                <h5 class="contact">
                    {{ $user->contact_number }}
                </h5>
                <h5 class="address">
                    {{$address}}
                </h5>
            </div>
            @endforeach
        </div>
        <div class="summary">
            <div class="main_profile_con">
                <div class="checkout-summary">
                    <h3 class="modal_customer_services_title">
                        {{$serviceName}}
                    </h3>
                    <h6 class="customer_services_trans">
                        Transaction ID: {{$value->booking_id}}
                    </h6>
                    <h5>
                        Checkout Summary
                    </h5>
                    <table class="table table-striped user_info_table">
                        <tbody>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Schedule:
                                </th>
                                <td class="user_table_data float-right">
                                    {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                </td>
                            </tr>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Property:
                                </th>
                                <td class="user_table_data float-right">
                                    {{ $value->property_type}}
                                </td>
                            </tr>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    Price:
                                </th>
                                <td class="user_table_data float-right">
                                    ₱{{ $price }}
                                </td>
                            </tr>
                            <tr class="user_table_row">
                                <th scope="row" class="user_table_header">
                                    <h3>Subtotal:</h3>
                                </th>
                                <td class="user_table_data float-right">
                                    <h3><b>{{ $price }} Pesos</b></h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="footer" style="margin:0 auto;width:40%;">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Paypal Integration -->
    <script type="text/javascript" src="https://www.paypal.com/sdk/js?client-id=AXR1Mw2TTniagpmnaDLAt1gRjNhCtpRhlerD1xbxBamBRdZQjBvZeoKGMYVMOFn-Z_1xGtSoAccCa1wf&currency=PHP&locale=en_PH&disable-funding=credit,card"></script>
    <!-- Paypal Button -->
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and application content.
                return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ $price }}',
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
                var amount  = '{{ $price }}';
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
                        }
                    });
                    //Redirect to customer transaction when success
                    swal({
                        title: "Payment Successful!",
                        icon: "success",
                        button: "Close",
                    });
                    window.location.href = "{{ url('/customer/customer_transaction') }}";
                });
            },
            onCancel: function(data) {
                //Redirect to customer transaction when cancel payment
                swal({
                    title: "Cancel Payment!",
                    icon: "error",
                    button: "Close",
                });
            },
            }).render('#paypal-button-container');
        </script>
        @endforeach

    <!-- Popup when fail -->    
    @if(session('fail'))
    <script>
        swal({
            title: "Something went wrong, try again!",
            icon: "error",
            button: "Close",
        });
    </script>
    @endif 

    <!-- Mobile -->
    <div class="mobile-spacer">
    </div>
</body>
@endsection