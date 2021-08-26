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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">

</head>
<body>
<header>
    <div class="logo"> SWEEP </div>
    <nav>
        <ul>
            <li><a href="admin_dashboard">Home</a></li>
            <li><a class="active" href="admin_services">Services</a></li>
            <li><a href="admin_transaction">Transaction</a></li>
            <li><a href="admin_user">User</a></li>
            <li><a href="admin_payroll">Payroll</a></li>
            <div class="profile_btn" style="margin-left: 315px; margin-top: 8px;">
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
    <div class="search_con">
        <input class="searchbar" type="text" placeholder="Search..">
        <button class="search_btn">Search</button>
    </div>
    <div class="col-2 d-flex services_title_con">
        <div>
            <h1 class="cards_title">Services </h1> 
        </div>
        <div class="add_service_con">
            <button type="button" class="btn btn-block btn-primary add_service_btn" data-toggle="modal" data-target="#addService">
                + Add Service
            </button>
            <div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content service_modal_content">
                    <div class="modal-header service_modal_header">
                        <h5 class="modal-title" id="exampleModalLabel">New Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('store') }}" method="post" id="myform">
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
                        <div class="form-group">
                            <input type="text" class="form-control w-100 add_service_form" id="service_title" name="service_name" placeholder="Service Name" value="{{ old('service_name') }}">
                            <span class="text-danger">@error('service_name'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" name="description" placeholder="Description"  value="{{ old('description') }}" ></textarea>
                            <span class="text-danger">@error('description'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Equipments" name="equipment" value="{{ old('equipment') }}"></textarea>
                            <span class="text-danger">@error('equipment'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Materials" name="material" value="{{ old('material') }}" ></textarea>
                            <span class="text-danger">@error('material'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Personal Protection" name="personal_protection" value="{{ old('personal_protection') }}" ></textarea>
                            <span class="text-danger">@error('personal_protection'){{ $message }} @enderror</span>
                        </div>
                        <h5 class="pricing_title">
                           Number of Cleaner
                        </h5>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="resident_number_of_cleaner" placeholder="Residential Areas" value="{{ old('resident_number_of_cleaner') }}">
                            <span class="text-danger">@error('resident_number_of_cleaner'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="apartment_number_of_cleaner" placeholder="Apartments" value="{{ old('apartment_number_of_cleaner') }}">
                            <span class="text-danger">@error('apartment_number_of_cleaner'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="condo_number_of_cleaner" placeholder="Condominiums" value="{{ old('condo_number_of_cleaner') }}">
                            <span class="text-danger">@error('condo_number_of_cleaner'){{ $message }} @enderror</span>
                        </div>
                        <h5 class="pricing_title">
                           Pricing
                        </h5>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_residential" name="resident_price" placeholder="Residential Areas" value="{{ old('resident_price') }}">
                            <span class="text-danger">@error('resident_price'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_apartment" name="apartment_price" placeholder="Apartments" value="{{ old('apartment_price') }}">
                            <span class="text-danger">@error('apartment_price'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_condo" name="condo_price" placeholder="Condominiums" value="{{ old('condo_price') }}">
                            <span class="text-danger">@error('condo_price'){{ $message }} @enderror</span>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer service_modal_header">
                        <button form="myform" type="submit" class="btn btn-primary update_btn">ADD</button>
                        <button type="button" class="btn btn-block btn-primary delete_btn" class="close" data-dismiss="modal">CANCEL</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $service_data = Service::all();
    ?>
    @foreach($service_data as $key => $value)
    <div class="services_con">
        <div class="row row_services">
            <div class="column col_services">
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="broom_img p-1">
                        <h3 class="service_title">{{ $value->service_name }}</h3>
                    </div>
                    <div>
                        <p class="service_description">
                        {{ $value->service_description }}
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#serviceDetail-{{ $value->service_id }}" >
                            View Details
                        </button>
                       
                        <!-- Modal -->
                        <div class="modal fade" id="serviceDetail-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3 service_modal_content">
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">{{ $value->service_name }}</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                    {{ $value->service_description }}
                                    </p>
                                    <ul class="package_list">
                                        <li><b>Equipment:</b> {{ $value->equipment }}</li>
                                        <li><b>Materials:</b> {{ $value->material }}</li>
                                        <li><b>Personal Protection:</b> {{ $value->personal_protection }}</li>
                                        <br>
                                    <!-- Retrieve Price Data from Database -->
                                    <?php
                                    $prices = Price::Where('service_id', $value->service_id )->get();
                                    ?>
                                    @foreach($prices as $key => $value)
                                        <li><b>{{ $value->property_type }}</b></li>
                                        <li><b>Price: P{{ $value->price }}</b></li>
                                        <li><b>Cleaners:</b> {{ $value->number_of_cleaner }}</li>
                                        <br>
                                    @endforeach     
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" data-toggle="modal" data-target="#updateService-{{ $value->service_id }}" class="btn btn-block btn-primary update_btn" class="close-modal" >UPDATE</button>
                                    @method('DELETE')
                                    <button type="button" onclick='return confirm("Are you sure?")' href="{{ route('destroy', $value->service_id) }}" class="btn btn-block btn-primary delete_btn"  data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            
            <div class="modal fade" id="updateService-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <?php
                $service_data = Service::Where('service_id', $value->service_id )->get();
            ?>
            @foreach($service_data as $key => $value)
 
            <div class="modal-dialog" role="document">
                    <div class="modal-content service_modal_content">
                    <div class="modal-header service_modal_header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('update') }}" method="post" id="update">
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
                         
                        <div class="form-group">
                            <input type="text" class="form-control w-100 add_service_form" id="service_title" name="service_name" placeholder="Service Name" value="{{ old('service_name',$value->service_name) }}">
                            <span class="text-danger">@error('service_name'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" name="description" placeholder="Description"  >{{ $value->service_description }}</textarea>
                            <span class="text-danger">@error('description'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Equipments" name="equipment">{{ $value->equipment }}</textarea>
                            <span class="text-danger">@error('equipment'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Materials" name="material" >{{ $value->material }}</textarea>
                            <span class="text-danger">@error('material'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Personal Protection" name="personal_protection" >{{ $value->personal_protection }}</textarea>
                            <span class="text-danger">@error('personal_protection'){{ $message }} @enderror</span>
                        </div>
                        <?php
                            $resident_price = Price::Where('service_id', $value->service_id )->Where('property_type', 'Medium-Upper Class Residential Areas' )->value('price');
                            $resident_cleaner = Price::Where('service_id', $value->service_id )->Where('property_type', 'Medium-Upper Class Residential Areas' )->value('number_of_cleaner');
                            $apartment_price = Price::Where('service_id', $value->service_id )->Where('property_type', 'Apartments' )->value('price');
                            $apartment_cleaner = Price::Where('service_id', $value->service_id )->Where('property_type', 'Apartments' )->value('number_of_cleaner');
                            $condo_price = Price::Where('service_id', $value->service_id )->Where('property_type', 'Condominiums' )->value('price');
                            $condo_cleaner = Price::Where('service_id', $value->service_id )->Where('property_type', 'Condominiums' )->value('number_of_cleaner');
                        ?>
                        
                        <h5 class="pricing_title">
                           Number of Cleaner
                        </h5>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="resident_number_of_cleaner" placeholder="Residential Areas" value="{{old('resident_number_of_cleaner',$resident_cleaner)}}">
                            <span class="text-danger">@error('resident_number_of_cleaner'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="apartment_number_of_cleaner" placeholder="Apartments" value="{{old('apartment_number_of_cleaner',$apartment_cleaner )}}">
                            <span class="text-danger">@error('apartment_number_of_cleaner'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="condo_number_of_cleaner" placeholder="Condominiums" value="{{ old('condo_number_of_cleaner', $condo_cleaner) }}">
                            <span class="text-danger">@error('condo_number_of_cleaner'){{ $message }} @enderror</span>
                        </div>
                        <h5 class="pricing_title">
                           Pricing
                        </h5>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_residential" name="resident_price" placeholder="Residential Areas" value="{{ old('resident_price', $resident_price) }}">
                            <span class="text-danger">@error('resident_price'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_apartment" name="apartment_price" placeholder="Apartments" value="{{ old('apartment_price', $apartment_price) }}">
                            <span class="text-danger">@error('apartment_price'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_condo" name="condo_price" placeholder="Condominiums" value="{{ old('condo_price', $condo_price) }}">
                            <span class="text-danger">@error('condo_price'){{ $message }} @enderror</span>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer service_modal_header">
                        <button form="update" type="submit" class="btn btn-primary update_btn" class="close-modal">UPDATE</button>
                        <button type="button" class="btn btn-block btn-primary delete_btn" class="close" data-dismiss="modal">CANCEL</button>
                    </div>
                    </div>
                    @endforeach
          
                </div>
            </div>
            @endforeach
</body>
</html>
