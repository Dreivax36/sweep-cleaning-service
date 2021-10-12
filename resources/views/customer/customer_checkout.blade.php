<?php
    use App\Models\Booking;
    use App\Models\Service;
    use App\Models\Price;
?>

@extends('customer/customer-nav/head_extention_customer-transactions')

@section('content')

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/customer_checkout.css') }}" rel="stylesheet">
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
<?php
    $booking = Booking::where('booking_id', $booking_id)->get();
    ?>
    @foreach($booking as $value)
    <?php
    $serviceName = Service::where('service_id', $value->service_id)->value('service_name');
    $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->value('price');
    ?>
    
    <div class="row justify-content-center">
        <div class="main_profile_con">
            <div class="checkout-summary">
            <button type="button" class="close-mobile" data-dismiss="modal" onclick="document.location='{{ route('customer.customer_transaction') }}'">
                <i class="fas fa-arrow-to-left"></i>Back
            </button>
            <br>
            <h2>
                Payment Summary
            </h2>
          
            <h4 class="modal_customer_services_title">
                {{$serviceName}}
            </h4>
            <h6 class="customer_services_trans">
                Transaction ID: {{$value->booking_id}}
            </h6>

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
                    </tbody>
                </table>

                <h4>Subtotal: <b class="float-right">{{ $price }} Pesos</b></h4> 
            </div>
            <br>
            <div class="footer">
                <div id="paypal-button-container"></div>
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
                window.location.href = "{{ url('/customer/customer_transaction') }}";
                });
            },
            onCancel: function(data) {
                alert("Payment cancelled");
                window.location.href = "{{ url('/customer/customer_transaction') }}";
            },
            }).render('#paypal-button-container');
        </script>
        @endforeach
    <div class="mobile-spacer">

    </div>
    
</body>
@endsection