<?php
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Service_review;
    use App\Models\Notification;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Services Page
    </title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light sweep-nav shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brandname" href="{{ url('/') }}">
                    SWEEP
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class= "navbar-nav ml-auto">    
                        <a href="admin_dashboard" class="nav-link">Home</a>
                        <a class="nav-link" href="admin_services" role="button" id="active">Services</a>
                        <a class="nav-link" href="admin_transaction" role="button">Transactions</a>
                        <a class="nav-link" href="admin_user" role="button">User</a>
                        <a class="nav-link" href="admin_payroll" role="button">Payroll</a>
                        <!-- Notification -->
                        <li class="nav-item dropdown" id="admin">
                            <?php
                                  $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                                  $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                              ?>
                           <a id="navbarDropdown admin" class="nav-link"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-bell"></i> 
                                @if($notifCount != 0)
                                    <span class="badge alert-danger pending">{{$notifCount}}</span>
                                @endif
                            </a>    
                            <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                                @forelse ($notif as $notification)
                                <a class="dropdown-item read" id="refresh" style="background-color:#f2f3f4; border:1px solid #dcdcdc" href="/{{$notification->location}}/{{$notification->id}}">
                                    {{ $notification->message}}
                                </a>
                                @empty
                                <a class="dropdown-item">
                                    No record found
                                </a>
                                @endforelse 
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $LoggedUserInfo['email'] }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" data-dismiss="modal" data-toggle="modal" data-target="#logout">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

<body> 
    <div class="col-2 d-flex services_title_con">
        <div>
            <h1 class="cards_title">
                SERVICES
            </h1> 
        </div>
        <div class="add_service_con"> <!-- Add Service -->
            <button type="button" class="btn btn-block btn-primary add_service_btn" data-toggle="modal" data-target="#exampleModal1">
                + Add Service
            </button>
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 70%;">
                <div class="modal-content service_modal_content">
                    <div class="modal-header service_modal_header">
                        <h4 class="modal-title" id="exampleModalLabel">
                            Add New Service
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for adding services -->
                        <form action="{{ route('store') }}" method="post" id="myform">
                            @if(Session::get('success-add'))
                                <script>
                                    swal({
                                        title: "Service added successfully!",
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
                            <div class="row">
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        </div>
                                        <div class="col-md-6">   
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                             </form>
                        </div>
                        <div class="modal-footer service_modal_header">
                            <button form="myform" type="submit" class="btn btn-primary update_btn">
                                ADD
                            </button>
                            <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                CANCEL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of Add Service -->
    </div>

    <?php
        $service_data = Service::all();
    ?>

    <div class="services_con">
    @foreach($service_data as $key => $value)
            <div class="column col_services" id="card-lists">
                <div class="card card_services p-4">
                    <div class="d-flex card_body">
                        <img src="/img/broom.png" class="broom_img p-1">
                        <div style="margin-left:10px;">
                        <h3 class="card-title service_title">
                            {{ $value->service_name }}
                        </h3>
                        <?php
                            $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                            $avg = (int)$total;
                                                    
                            for ( $i = 1; $i <= 5; $i++ ) {
                                if ( $avg >= $i ) {
                                    echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                } else {
                                    echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                }
                            }
                            echo '</span>';
                        ?>
                        </div>
                    </div>
                    <div>
                        <p class="service_description">
                        {{ \Illuminate\Support\Str::limit($value->service_description, 200, $end='...') }}
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#details-{{ $value->service_id }}">
                            View Details
                        </button>
                        <div class="modal fade" id="details-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document" style="max-width: 70%;">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content -->
                                <div class="modal-header service_modal_header">
                                
                                    <img src="/img/broom.png" class="broom_img_inside p-1">
                                    <div style="margin-left:20px;">
                                    <h4 class="modal_service_title">
                                        {{ $value->service_name }}
                                    </h4>
                                    <?php
                                        $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                                        $avg = (int)$total;
                                                    
                                        for ( $i = 1; $i <= 5; $i++ ) {
                                            if ( $avg >= $i ) {
                                                echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                            } else {
                                                echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                            }
                                        }
                                        echo '</span>';
                                    ?>
                                    </div>
                               
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                <div class="row">
                                <div class="col-md-6">
                                    <p class="service_description">
                                        {{ $value->service_description }}
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Equipment:</b> {{ $value->equipment }}
                                        </li>
                                        <li>
                                            <b>Materials:</b> {{ $value->material }}
                                        </li>
                                        <li>
                                            <b>Personal Protection:</b> {{ $value->personal_protection }}
                                        </li>
                                        <br>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                    <ul class="package_list">
                                        <!-- Retrieve Price Data from Database -->
                                        <?php 
                                            $price_data = Price::Where('service_id', $value->service_id )->get();
                                        ?>
                                        @foreach($price_data as $key => $value)
                                            <li>
                                                <b>{{ $value->property_type }}</b>
                                            </li>
                                            <li>
                                                <b>Price:</b> ₱{{ $value->price }}
                                            </li>
                                            <li>
                                                <b>Cleaners:</b> {{ $value->number_of_cleaner }}
                                            </li>
                                            <br>
                                        @endforeach     
                                    </ul>
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <!-- Update and Delete a Service -->
                                    <button type="button" data-toggle="modal" data-target="#updateService-{{ $value->service_id }}" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#delete-{{ $value->service_id }}"  class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content --> 
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div>

            <!-- Modal -->
    <div class="modal fade" id="delete-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{ route('destroy') }}" method="post" id="delete">
                        @if(Session::get('success-delete'))
                            <script>
                            swal({
                                title: "Service deleted successfully!",
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
                    Are you sure you want to delete a service?
   
                </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button form="delete" type="submit"  name="service_id" value="{{$value->service_id}}" class="btn btn-danger">YES</button>
                </div>
            </div>
        </div>
    </div>
            
            <!-- Modal for Updating a Service -->
            <div class="modal fade" id="updateService-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            
                <?php
                    $service_data = Service::Where('service_id', $value->service_id )->get();
                ?>
                @foreach($service_data as $key => $value)
 
                <div class="modal-dialog" role="document" style="max-width: 70%;">
                    <div class="modal-content service_modal_content">
                        <div class="modal-header service_modal_header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Update Service
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="modal-body">
                        
                    <!-- Form for Updating a Service -->
                    <form action="{{ route('update') }}" method="post" >
                    @if(Session::get('success'))
                            <script>
                            swal({
                                title: "Service updated successfully!",
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
                        <input type="hidden" name="service_id" value="{{ $value->service_id }}"> 
                        <div class="row">
                            <div class="col-md-6">  
                        <div class="form-group">
                            <input type="text" class="form-control w-100 add_service_form" id="service_title" name="service_name" placeholder="Service Name" value="{{ old('service_name',$value->service_name) }}">
                            <span class="text-danger">
                                @error('service_name'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" name="description" placeholder="Description"  >{{ $value->service_description }}</textarea>
                            <span class="text-danger">
                                @error('description'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Equipments" name="equipment">{{ $value->equipment }}</textarea>
                            <span class="text-danger">
                                @error('equipment'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Materials" name="material" >{{ $value->material }}</textarea>
                            <span class="text-danger">
                                @error('material'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control w-100 add_service_form" id="description" placeholder="Personal Protection" name="personal_protection" >{{ $value->personal_protection }}</textarea>
                            <span class="text-danger">
                                @error('personal_protection'){{ $message }} @enderror
                            </span>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6"> 
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
                            <span class="text-danger">
                                @error('resident_number_of_cleaner'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="apartment_number_of_cleaner" placeholder="Apartments" value="{{old('apartment_number_of_cleaner',$apartment_cleaner )}}">
                            <span class="text-danger">
                                @error('apartment_number_of_cleaner'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="service_cleaners" name="condo_number_of_cleaner" placeholder="Condominiums" value="{{ old('condo_number_of_cleaner', $condo_cleaner) }}">
                            <span class="text-danger">
                                @error('condo_number_of_cleaner'){{ $message }} @enderror
                            </span>
                        </div>
                        </div>
                        <div class="col-md-6"> 
                        <h5 class="pricing_title">
                            Pricing
                        </h5>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_residential" name="resident_price" placeholder="Residential Areas" value="{{ old('resident_price', $resident_price) }}">
                            <span class="text-danger">
                                @error('resident_price'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_apartment" name="apartment_price" placeholder="Apartments" value="{{ old('apartment_price', $apartment_price) }}">
                            <span class="text-danger">
                                @error('apartment_price'){{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control w-100 add_service_form" id="property_condo" name="condo_price" placeholder="Condominiums" value="{{ old('condo_price', $condo_price) }}">
                            <span class="text-danger">
                                @error('condo_price'){{ $message }} @enderror
                            </span>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>          
                    </div>
                        <div class="modal-footer service_modal_header">
                            <button  type="submit" class="btn btn-primary update_btn" class="close-modal">
                                UPDATE
                            </button>
                            <button type="button" class="btn btn-block btn-primary delete_btn" class="close" data-dismiss="modal">
                                CANCEL
                            </button>
                        </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div> <!-- End of Modal for Updating a Service -->
            @endforeach
        </div>
    <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('21a2d0c6b21f78cd3195', {
    cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {
        
       
        var result = data.messages;
            var pending = parseInt($('#admin').find('.pending').html());
            if(pending) {
                $('#admin').find('.pending').html(pending + 1);
            }else{
                $('#admin').find('.pending').html(pending + 1);
            } 
            $('#refresh').load(window.location.href + " #refresh");
        });

    </script>    

    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            <div class="icon">
                <i class="fa fa-sign-out-alt"></i>
            </div>
            <div class="title">
                Are you sure you want to logout?
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">Yes</button>
        </div>
        </div>
    </div>
    </div>
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer> 
</body>
@endsection
