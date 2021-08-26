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

    <title>SWEEP</title>

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
</head>
<body>
    <header>
        <div class="logo"> SWEEP </div>
        <nav>
            <ul>
                <li><a href="admin_dashboard">Home</a></li>
                <li><a href="admin_services">Services</a></li>
                <li><a  class="active" href="admin_transaction">Transaction</a></li>
                <li><a href="admin_user">User</a></li>
                <li><a href="admin_payroll">Payroll</a></li>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                    <img src="/img/user.png" class="profile_img">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                    </div>
                </div> 
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header>
    <div class="row"> 
        <a class="user_type_btn" id="active" href="admin_transaction">
            TRANSACTION 
            <p class="total_value">(63)</p>
        </a>
        <a class="user_type_btn" href="admin_transaction_history">
            HISTORY 
            <p class="total_value">(63)</p>
        </a>
    </div>
    <div class="adjust_con">
        <div>
            <input class="searchbar" type="text" placeholder="Search..">
            <button class="search_btn">Search</button>
        </div>
    </div>
   
    <?php
        $booking_data = Booking::Where('status', '!=' , 'Done')->get();
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
    <div class="transaction_con">
        <div class="row row_transaction">
            <div class="column col_transaction">
                <div class="card card_transaction p-4">
                    <div class="d-flex">
                        <i class="bi bi-card-checklist check_icon_outside"></i>
                        <h3 class="service_title_trans">{{ $data->service_name}}</h3>
                        <h5 class="service_status">{{ $value->status }}</h5>
                    </div>
                    <div> 
                        <h6 class="booking_date"><b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</h6>
                    </div>
                    <div>
                        <table class="table table-striped user_info_table">
                            <tbody>
                                <tr class="user_table_row">
                                <th scope="row" class="user_table_header">Customer:</th>
                                <td class="user_table_data">{{ $user->full_name }}</td>
                                </tr>
                                <tr class="user_table_row">
                                <th scope="row" class="user_table_header">Address:</th>
                                <td class="user_table_data">{{ $address->address }}</td>
                                </tr>
                                <tr class="user_table_row">
                                <th scope="row" class="user_table_header">Contact Info:</th>
                                <td class="user_table_data">{{ $user->contact_number }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                    
                            <div class="modal-content p-3 trans_modal_content">
                                <div class="modal-header trans_modal_header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check_icon_inside"></i>
                                    <h4 class="modal_service_title_trans">{{ $data->service_name}}</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
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

                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                   
                                        <li><b>Customer:</b></li>
                                        <li class="list_booking_info"><b>Name:</b> {{ $user->full_name }}</li>
                                        <li class="list_booking_info"><b>Contact Number:</b> {{ $user->contact_number }}</li>
                                        <li class="list_booking_info"><b>Address:</b> {{ $address->address }}</li>
                                       
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list_booking_info"><b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</li>
                                        <li class="list_booking_info"><b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}</li>
                                        <li class="list_booking_info"><b>Property Type:</b> {{ $value->property_type}}</li>
                                        <li class="list_booking_info"><b>Status:</b> {{ $value->status }}</li>
                                        <li class="list_booking_info"><b>Price:</b> P{{ $price_data->price }}</li>

                                        <br>
                                        <?php
                                            $cleaner_id = Cleaner::Where('cleaner_id', $value->cleaner_id )->value('user_id');
                                            $full = User::Where('user_id', $cleaner_id )->value('full_name');
                                        ?>
                                        
                                        <li><b>Cleaners:</b></li>

                                        <li class="list_booking_info"><b>Name: </b>{{ $full }}</li>
                                                
                                    </ul>
                                </div>
                                </form>
                                <div class="modal-footer trans_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary accept_btn" data-toggle="modal" data-target="#exampleModalLong101">ACCEPT</button>
                                    <button form="myform" type="submit" class="btn btn-block btn-primary decline_btn" name="status" value="Decline" >DECLINE</button>
                                </div>
                                <div class="modal-footer customer_services_modal_footer">
                                <div class="modal fade" id="exampleModalLong101" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <!-- Modal content-->
                                                    <div class="modal-content p-3 trans_modal_content">
                                                        <div class="modal-header trans_modal_header">
                                                        <div class="d-flex pt-5">
                                                           
                                                            <h4 class="modal_service_title_trans">Assign {{ $price_data->number_of_cleaner}} Cleaners</h4>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                                <form action="{{ route('updateStatus') }}" method="post" id="my">
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
                                                                @foreach($cleaner_data as $key => $cleaner)
                                                                <?php
                                                                    $cleaner_id = Cleaner::Where('user_id', $cleaner->user_id )->value('cleaner_id');
                                                                ?>
                                                                 @foreach($cleaner_id as $key => $id)
                                                                <br>
                                                                <fieldset>
                                                                    <input type="hidden" name="service_id" value="{{ $value->service_id }}">
                                                                    <input type="checkbox" id="full_name" name="cleaner_id[]" value="{{ $id->cleaner_id }}">
                                                                    <label for="full_name"> {{ $cleaner->full_name }}</label><br>
                                                                </fieldset>
                                                                @endforeach
                                                                @endforeach
                                                                
                                                                <br>
                                                                <div class="modal-footer trans_modal_footer">
                                                                    <button type="button" class="btn btn-block btn-primary decline_btn" data-dismiss="modal"> Cancel </button>
                                                                    <button form="my" type="submit" class="btn btn-block btn-primary accept_btn" name="status" value="Accepted"> Confirm </button>
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
    @endforeach
    @endforeach
    @endforeach
    @endforeach
</body>
</html>