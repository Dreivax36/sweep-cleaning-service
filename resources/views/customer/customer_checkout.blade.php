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
    $userId = Customer::Where('customer_id', $value->customer_id )->value('user_id');
    $user_data = User::Where('user_id', $userId )->get();
    $addressData = Address::Where('customer_id', $value->customer_id )->get();
    $address = Address::Where('customer_id', $value->address_id )->value('address');
    ?>
    <div class="banner">
        <div class="p-4 customer_cards_title">
            <button type="button" class="close-mobile" data-dismiss="modal">
                <i class="fas fa-arrow-to-left"></i>Back
            </button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="info">
            <div class="d-flex">
                <h3>
                    <i class="fas fa-map-marker-alt"></i> Customer Information:
                </h3>
            </div>
            <div class="change_info btn-link float-right" data-toggle="modal" data-target="#addresses-{{$value->booking_id}}">
                CHANGE
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
        <div class="modal fade" id="addresses-{{$value->booking_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <!-- Modal -->
            <div class="modal-dialog" role="document">
                <div class="modal-content customer_services_modal_content">
                    <!-- Modal Content -->
                    <div class="modal-header customer_services_modal_header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <h4 class="modal_customer_services_title">
                                    Property Address
                                </h4>
                            </div>
                        </div>

                    </div>

                    <div class="modal-body">
                       
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
        <div class="modal fade" id="addAddress-{{$value->booking_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <!-- Modal -->
            <div class="modal-dialog" role="document">
                <div class="modal-content customer_services_modal_content">
                    <!-- Modal Content -->
                    <div class="modal-header customer_services_modal_header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <h4 class="modal_customer_services_title">
                                    Add Address
                                </h4>
                            </div>
                        </div>

                    </div>

                    <div class="modal-body">
                      
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
                    }
                });
                $(function(){
                    $('#success-pay').modal('show');
                });
                window.location.href = "{{ url('/customer/customer_transaction') }}";
                });
            },
            onCancel: function(data) {
                $(function(){
                    $('#error').modal('show');
                });
                window.location.href = "{{ url('/customer/customer_transaction') }}";
            },
            }).render('#paypal-button-container');
        </script>
        @endforeach
     
    <div class="modal fade" id="success-pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-check"></i>
            </div>
            <div class="title">
                Payment Successful
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <div class="title">
                Something went wrong, try again.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <div class="mobile-spacer">

    </div>
    
</body>
@endsection