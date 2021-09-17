<?php
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Booking;
?>

@extends('head_extention_customer') 

@section('content')
    <title>
        Customer Services Page
    </title>
    <script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        </script>
    </script>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> 
            SWEEP 
        </div>
        <nav >
            <ul >
                <li>
                    <a href="customer_dashboard">
                        Home
                    </a>
                </li>
                <li>
                    <a href="customer_services" class="active">
                        Services
                    </a>
                </li>
                <li>
                    <a href="customer_transaction">
                        Transaction
                    </a>
                </li>
                <li>
                    <a href="customer_history">
                        History
                    </a>
                </li>
                
                <li class="dropdown" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        <img src="/img/user.png" class="profile_img">   
                    </a>
            
                    <ul class="dropdown-menu listRight" >
                        <li><a class="dropdown-item" href="customer_profile">
                            Profile
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('auth.logout') }}">
                            Logout
                        </a></li>
                    </ul>
               
                </li>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar -->

    <div class="customer_search_con"> <!-- Search Field -->
        <form action="/action_page.php">
            <input type="text" placeholder="Search" name="search" class="customer_search_field">
        </form>
    </div> <!-- End of Search Field -->
   
    <div class="col-2 d-flex customer_services_title_con">
        <div>
            <h1 class="customer_cards_title">
                SERVICES
            </h1> 
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
                                $price_start = Price::Where('property_type', 'Apartments' )->Where('service_id', $value->service_id )->value('price');
                                $price_end = Price::Where('property_type', 'Medium-Upper Class Residential Areas' )->Where('service_id', $value->service_id )->value('price');
                            ?>

                            <h3 class="customer_services_title">
                                {{ $value->service_name }}
                            </h3>
                           
                            <h6 class="customer_services_sub_1">
                                Price starts at P{{ $price_start }}
                            </h6>
                            
                            <div class="view_details_con">
                                <button type="button" class="btn btn-link customer_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->service_id }}">
                                    DETAILS 
                                </button>
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
                                                    <li>
                                                        <b>Equipment:</b>{{ $value->equipment }}
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Materials:</b>{{ $value->material }}
                                                    </li>
                                                    <br>
                                                    <li>
                                                        <b>Personal Protection:</b>{{ $value->personal_protection }}
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
                                                            <b>{{ $data->price }}</b>
                                                        </li>
                                                        <li>
                                                            <b>Cleaners:</b> {{ $data->number_of_cleaner }}
                                                        </li>
                                                        <br>
                                                    @endforeach
                                                </ul> 
                                            </div> 
                                        </div>
                                        <div class="modal-footer customer_services_modal_footer">
                                        @if($LoggedUserInfo['account_status'] == "Verified")
                                            <button type="button" class="btn btn-block btn-primary book_now_btn" data-toggle="modal" data-target="#exampleModalLong101-{{ $value->service_id }}">
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
                                    </div> <!-- End of Modal Content --> 
                                    </div>
                                </div> <!-- End of Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endforeach

     <?php
     
        $scheduledate = Booking::select('schedule_date')->get();
    ?>
    @if ($scheduledate != null)
        <script>
        var array = ["2019-03-14", "2019-03-11", "2019-03-26"];

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
