<?php
use App\Models\Service;
use App\Models\Price;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Customer Services</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
                $('.menu-toggle').click(function(){
                    $('nav').toggleClass('active')
                })
            })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_customer.css')}}">
</head>
<body>
    <header>
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li ><a href="customer_dashboard">Home</a></li>
                <li  class="active"><a href="customer_services">Services</a></li>
                <li><a href="customer_transaction">Transaction</a></li>
                <li><a href="customer_history">History</a></li>
                <div class="customer_notif_icon">
                    <button class="btn dropdown-toggle dropdown_notif_icon" type="button" id="menu2" data-toggle="dropdown" >
                        <i class="bi bi-bell"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Notification 1</a>
                    <a class="dropdown-item" href="#">Notification 2</a>
                </div>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img src="/img/user.png" class="profile_img">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="customer_profile">Profile</a>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header>
    <div class="customer_search_con">
        <form action="/action_page.php">
            <input type="text" placeholder="Search" name="search" class="customer_search_field">
        </form>
    </div>
    <div class="col-2 d-flex customer_services_title_con">
        <div>
            <h1 class="customer_cards_title">SERVICES</h1> 
        </div>
    </div>
    <?php
        $service_data = Service::all();
    ?>
    @foreach($service_data as $key => $value)
 
    <div class="customer_services_con">
        <div class="column col_customer_services">
            <div class="row row_customer_services">
                <div class="card card_customer_services p-4">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="customer_services_broom_img p-1">
                        <div class="d-flex flex-column">
                        <?php
                            $price_data = Price::Where('property_type', 'Apartments' )->get();
                        ?>
                            <h3 class="customer_services_title">{{ $value->service_name }}</h3>
                            @foreach($price_data as $key => $price_start)
                            <h6 class="customer_services_sub_1">Price starts at P{{ $price_start->price }}</h6>
                            
                            <div class="view_details_con">
                                <button type="button" class="btn btn-link customer_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS 
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <!-- Modal content-->
                                    <div class="modal-content p-4 customer_services_modal_content">
                                        <div class="modal-header customer_services_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="customer_services_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="modal_customer_services_title">{{ $value->service_name }}</h4>
                                                <?php
                                                    $price_data = Price::Where('property_type', 'Medium-Upper Class Residential Areas' )->get();
                                                ?>
                                                @foreach($price_data as $key => $price_end)
                                                <h6 class="customer_services_sub_1">Price starts at P{{ $price_start->price }} - P{{ $price_end->price }}</h6>
                                                @endforeach
                                                @endforeach
                                                <img src="/img/stars.png" class="five_stars_img">
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_services_modal_body_1_con">
                                            <p class="customer_services_description">
                                            {{ $value->description }}
                                            </p>
                                            <ul class="customer_package_list">
                                                <li><b>Equipment:</b> {{ $value->equipment }}</li>
                                                <br>
                                                <li><b>Materials:</b> {{ $value->material }}</li>
                                                <br>
                                                <li><b>Personal Protection:</b> {{ $value->personal_protection }}</li>
                                                <br>
                                                      
                                            </ul>
                                            </div>
                                            <?php
                                                $price_data = Price::Where('service_id', $value->service_id )->get();
                                            ?>
                                            
                                            <div class="d-flex flex-column modal_body_2_con">
                                            
                                                <ul class="customer_package_list customer_property_list">
                                                @foreach($price_data as $key => $data)
                                                    <li><b>{{ $data->property_type }}</b></li>
                                                    <li><b>{{ $data->price }}</b></li>
                                                    <li><b>Cleaners:</b> {{ $data->number_of_cleaner }}</li>
                                                    <br>
                                                    @endforeach
                                                </ul> 
                                            </div> 
                                           
                                        </div>
                                        <div class="modal-footer customer_services_modal_footer">
                                            <button type="button" class="btn btn-block btn-primary book_now_btn" data-toggle="modal" data-target="#exampleModalLong101">
                                                BOOK NOW
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalLong101" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <!-- Modal content-->
                                                    <div class="modal-content customer_services_modal_content_inside">
                                                        <div class="modal-header customer_services_modal_header_inside">
                                                            <div class="p-3 customer_services_modal_inside_con">
                                                                <h3 class="customer_services_modal_title">Light Cleaning</h3>
                                                                <form action="{{ route('book') }}" method="post" id="myform">
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
                                                                <label for="appt">Date:</label>
                                                                <input type="date" id="schedule_date" name="schedule_date"><br>
                                                                <label for="appt">Time:</label>
                                                                    <input type="time" id="schedule_time" name="schedule_time">
                                                                <div class="d-flex cancel_confirm_con">
                                                                    <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> Cancel </button>
                                                                    <button form="myform" type="submit" class="btn btn-block btn-primary confirm_btn"> Confirm </button>
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
        </div>
    </div>
    @endforeach
</body>
</html>