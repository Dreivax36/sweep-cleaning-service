<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cleaner Job</title>

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_cleaner.css')}}">
</head>
<body>
    <header>
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li><a href="cleaner_dashboard">Home</a></li>
                <li class="active"><a href="cleaner_job">Jobs</a></li>
                <li><a href="cleaner_history">History</a></li>
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
                    <a class="dropdown-item" href="#">Profile</a>
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
    <div class="col-2 d-flex cleaner_job_title_con">
        <div>
            <h1 class="cleaner_cards_title">Jobs</h1> 
        </div>
    </div>
    <?php
        $booking_data = Booking::all();
    ?>
    @foreach($booking_data as $key => $value)
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $user_data = User::Where('user_id', $value->customer_id )->get();
        $address_data = Address::Where('customer_id', $value->customer_id )->get();
        $price = Price::Where('property_type', $value->property_type )->get();
        $cleaner_data = User::Where('user_type', 'Cleaner' )->get();
    ?>
    @foreach($service_data as $key => $data)
    @foreach($price as $key => $price_data)
    @foreach($user_data as $key => $user)
    @foreach($address_data as $key => $address)
    <div class="cleaner_job_con">
        <div class="column col_cleaner_job">
            <div class="row row_cleaner_job">
                <div class="card p-4 card_cleaner_job">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="cleaner_job_broom_img p-1">
                        <div class="d-flex flex-column">
                            <h5 class="cleaner_job_status">{{ $value->status }}</h5>
                            <h3 class="cleaner_job_title">{{ $data->service_name}}</h3>
                            <h6 class="cleaner_job_date_1_1">{{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</h6>
                            <h6 class="cleaner_job_price_1">P{{ $price_data->price }}</h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link cleaner_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <!-- Modal content-->
                                    <form action="{{ route('updateStatus') }}" method="post" id="myform">
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
                                    <div class="modal-content p-4 cleaner_job_modal_content">
                                        <div class="modal-header cleaner_job_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="cleaner_job_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="cleaner_job_modal_title">{{ $data->service_name}}</h4>
                                                <h6 class="cleaner_job_modal_date_1_1">{{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</h6>
                                                <h6 class="cleaner_job_modal_amount_1">Total Amount: P{{ $price_data->price }}</h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="cleaner_job_modal_body_1_con">
                                                <ul class="cleaner_detail">
                                                    <li><b>Customer:</b></li>
                                                    <li class="list_booking_info"><b>Name:</b> {{ $user->full_name }}</li>
                                                    <li class="list_booking_info"><b>Contact Number:</b> {{ $user->contact_number }}</li>
                                                    <li class="list_booking_info"><b>Address:</b> {{ $address->address }}</li>
                                                    <br>
                                                    <li><b>Service Details:</b></li>
                                                    <li class="list_booking_info"><b>Property Type:</b> {{ $value->property_type}}</li>
                                                    <li class="list_booking_info"><b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</li>
                                                    <li class="list_booking_info"><b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}</li>
                                                    <li class="list_booking_info"><b>Status:</b> {{ $value->status }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer cleaner_job_modal_footer">
                                            <div class="on_progress_con">
                                                
                                                @if($value->status == "Accepted")
                                                <button form="myform" class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="On-Progress" >
                                                    ON-PROGRESS
                                                </button>    
                                                @endif

                                                @if($value->status == "On-Progress")
                                                <button form="myform" class="btn btn-block btn-primary on_progress_btn" type="submit" name="status" value="Done" >
                                                    DONE
                                                </button> 
                                                @endif
                                                    
                                                
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
    @endforeach
    @endforeach
    @endforeach
    @endforeach
</body>