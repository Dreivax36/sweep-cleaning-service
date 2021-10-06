@extends('/customer/customer-nav/head_extention_customer')

@section('content')
    <title>
        Customer Dashboard Page
    </title>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
<div class="banner-container">
        <div class="banner">
            <div class="text">
                <h1>The Road to Cleanliness has never been easier.</h1>
            </div>
            <div class="image">
                <img src="/images/services/header_img.png" class="img-fluid">
            </div>

        </div>
    </div>

            <div class="banner">
                <div class="book_container">
                    <h1 class="no_active">
                        The best cleaners are ready for your spaces!
                    </h1>
                    <p class="qoute">
                        Making your comfort zones squeaky clean one step at a time.
                    </p>
                    <a class="btn btn-primary down_btn btn-lg" href="{{ url('/customer/customer_services') }}">{{ __('Book Now') }}</a>
                </div>
            </div>
        
            <div class="recommendation">
                <div class="recom_title">
                    <h1 class="customer_cards_title">
                        Recommendations
                    </h1>
                </div>
                <div class="row1 justify-content-center">
                <div class="row" style="margin-left:5%;">
        <div class="col-md-6 columns">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-5 col-sm-5">
                                <img class="card-img" src="/images/services/general_cleaning.jpg" alt="Card image cap">
                            </div>
                            <div class="col-md-7 col-sm-7">

                                <div class="card-body">
                                    <h3 class="card-title">
                                        Deep Home Cleaning
                                    </h3>
                                    <div class="row">
                                        <div class="col">
                                            <div class="pricing">
                                                <h4 class="starts">Starts for as low as </h4>
                                                <div class="row pricing">
                                                    <div class="col-md-7 col-sm-6 price1 columns">
                                                        <h3 class="price">
                                                            ₱ 376.00
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-5 col-sm-6 book columns">
                                                        <div class="byt float-right">
                                                            <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong10">Book Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-md-6 columns">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-5 col-sm-5">
                                <img class="card-img" src="/images/services/general_cleaning.jpg" alt="Card image cap">
                            </div>
                            <div class="col-md-7 col-sm-7">

                                <div class="card-body">
                                    <h3 class="card-title">
                                        Deep Home Cleaning
                                    </h3>
                                    <div class="row">
                                        <div class="col">
                                            <div class="pricing">
                                                <h4 class="starts">Starts for as low as </h4>
                                                <div class="row pricing">
                                                    <div class="col-md-7 col-sm-6 price1 columns">
                                                        <h3 class="price">
                                                            ₱ 376.00
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-5 col-sm-6 book columns">
                                                        <div class="byt float-rightF">
                                                            <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong10">Book Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
    <div class="mobile-spacer">

</div>
<div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
</div>
</body>
@endsection