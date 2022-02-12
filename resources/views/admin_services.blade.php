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

<link rel="stylesheet" type="text/css" href="{{ asset('css/admin_services.css')}}">
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">

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
                <ul class="navbar-nav ml-auto">
                    <a href="admin_dashboard" class="nav-link">
                        Home
                    </a>
                    <a class="nav-link" href="admin_services" role="button" id="active">
                        Services
                    </a>
                    <a class="nav-link" href="admin_transaction" role="button">
                        Transactions
                    </a>
                    <a class="nav-link" href="admin_user" role="button">
                        User
                    </a>
                    <a class="nav-link" href="admin_payroll" role="button">
                        Payroll
                    </a>
                    <a class="nav-link" href="admin_reports" role="button">
                        Reports
                    </a>
                    <!-- Notification -->
                    <li class="nav-item dropdown" id="admin">
                        <?php
                            $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                            $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                        ?>
                        <a id="navbarDropdown admin" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-bell"></i>
                            @if($notifCount != 0)
                            <span class="badge alert-danger pending">{{$notifCount}}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                            @forelse ($notif as $notification)
                            <a class="dropdown-item read" id="refresh" href="/{{$notification->location}}/{{$notification->id}}">
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
    <div class="row head">
        <div class="col-md-8">
            <div>
                <h1 class="cards_title">
                    SERVICES
                </h1>
            </div>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-block btn-primary add_service_btn float-right" data-toggle="modal" data-target="#exampleModal1">
                + Add Service
            </button>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 70%;">
            <div class="modal-content service_modal_content">
                <div class="modal-header customer_services_modal_header">
                    <div>
                        <h4 class="modal_customer_services_title modal-title">
                            <b> 
                                Add New Service
                            </b>
                        </h4>
                    </div>
                    <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding services -->
                    <form action="{{ route('store') }}" method="post" id="myform" autocomplete="on">
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
                                    <label class="upload_label">
                                        Service Name
                                    </label>
                                    <input type="text" required class="form-control w-100 add_service_form" name="service_name" value="{{ old('service_name') }}" required>
                                    <span class="text-danger">@error('service_name'){{ $message }} @enderror</span>
                                </div>
                                <div class="form-group">
                                    <label class="upload_label">
                                        Description
                                    </label>
                                    <textarea required class="form-control w-100 add_service_form" name="description" value="{{ old('description') }}" required></textarea>
                                    <span class="text-danger">@error('description'){{ $message }} @enderror</span>
                                </div>
                                <div class="form-group">
                                    <label class="upload_label">
                                        Equipments
                                    </label>
                                    <h6 class="desc">
                                        <i>
                                            These are the things used during a service that are not consumable. Eg. Vaccuum Cleaner.
                                        </i>
                                    </h6>
                                    <textarea required class="form-control w-100 add_service_form" id="equipment" name="equipment" value="{{ old('equipment') }}" required></textarea>
                                    <span class="text-danger">@error('equipment'){{ $message }} @enderror</span>
                                </div>
                                <div class="form-group">
                                    <label class="upload_label">
                                        Materials
                                    </label>
                                    <h6 class="desc">
                                        <i>
                                            These are the things used during a service that are consumable. Eg. Soap.
                                        </i>
                                    </h6>
                                    <textarea required class="form-control w-100 add_service_form" id="material" name="material" value="{{ old('material') }}" required></textarea>
                                    <span class="text-danger">@error('material'){{ $message }} @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="upload_label">
                                        Personal Protection
                                    </label>
                                    <h6 class="desc">
                                        <i>
                                            These are neccesary protection for the cleaners for chemicals and particles. Eg. Gloves, Masks.
                                        </i>
                                    </h6>
                                    <textarea required class="form-control w-100 add_service_form" id="ppe" name="personal_protection" value="{{ old('personal_protection') }}" required></textarea>
                                    <span class="text-danger">@error('personal_protection'){{ $message }} @enderror</span>
                                </div>
                                <h5 class="pricing_title">
                                    Residential Areas
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 cleaner">
                                        <div class="">
                                            <h6 class="upload_label">
                                                No. of Cleaners:
                                            </h6>
                                            <div class="form-group">
                                                <input type="number" required class="form-control w-100 add_service_form" id="service_cleaners" name="resident_number_of_cleaner" value="{{ old('resident_number_of_cleaner') }}" onchange="this.value = Math.max(Math.ceil(Math.abs(this.value || 1)) || 1);" required>
                                                <span class="text-danger">@error('resident_number_of_cleaner'){{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 price">
                                        <div class="">
                                            <h6 class="upload_label">
                                                Price:
                                            </h6>
                                            <div class="form-group">
                                                <input type="number" required class="form-control w-100 add_service_form" id="property_residential" name="resident_price" value="{{ old('resident_price') }}" onchange="this.value = Math.max(Math.ceil(Math.abs(this.value || 1)) || 1);" required>
                                                <span class="text-danger">@error('resident_price'){{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="pricing_title">
                                    Apartments
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 cleaner">
                                        <div class="">
                                            <h6 class="upload_label">
                                                No. of Cleaners:
                                            </h6>
                                            <div class="form-group">
                                                <input type="number" required class="form-control w-100 add_service_form" id="service_cleaners" name="apartment_number_of_cleaner" value="{{ old('apartment_number_of_cleaner') }}" onchange="this.value = Math.max(Math.ceil(Math.abs(this.value || 1)) || 1);" required>
                                                <span class="text-danger">@error('apartment_number_of_cleaner'){{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 price">
                                        <div class="">
                                            <h6 class="upload_label">
                                                Price:
                                            </h6>
                                            <div class="form-group">
                                                <input type="number" required class="form-control w-100 add_service_form" id="property_apartment" name="apartment_price" value="{{ old('apartment_price') }}" onchange="this.value = Math.max(Math.ceil(Math.abs(this.value || 1)) || 1);" required>
                                                <span class="text-danger">@error('apartment_price'){{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="pricing_title">
                                    Condominiums
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 cleaner">
                                        <div class="">
                                            <h6 class="upload_label">
                                                No. of Cleaners:
                                            </h6>
                                            <div class="form-group">
                                                <input type="number" required class="form-control w-100 add_service_form" id="service_cleaners" name="condo_number_of_cleaner" value="{{ old('condo_number_of_cleaner') }}" onchange="this.value = Math.max(Math.ceil(Math.abs(this.value || 1)) || 1);" required>
                                                <span class="text-danger">@error('condo_number_of_cleaner'){{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 price">
                                        <div class="">
                                            <h6 class="upload_label">
                                                Price:
                                            </h6>
                                            <div class="form-group">
                                                <input type="number" required class="form-control w-100 add_service_form" id="property_condo" name="condo_price" value="{{ old('condo_price') }}" onchange="this.value = Math.max(Math.ceil(Math.abs(this.value || 1)) || 1);" required>
                                                <span class="text-danger">@error('condo_price'){{ $message }} @enderror</span>
                                            </div>
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
    <!-- End of Add Service -->

    <?php
        $service_data = Service::orderby('updated_at', 'desc')->get();
    ?>

    <div class="row justify-content-center">
        @foreach($service_data as $key => $value)
        <div class="card service-card">
            <div class="d-flex card_header service-header">
                <img src="/img/broom.png" class="broom_img p-1">
                <div style="margin-left:10px;">
                    <h3 class="card-title service_title">
                        {{ $value->service_name }}
                    </h3>
                    <?php
                        $reviewscount = Service_review::where('service_id', $value->service_id)->count();
                        $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                        $avg = (int)$total;

                        for ($i = 1; $i <= 5; $i++) {
                            if ($avg >= $i) {
                                echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                            } else {
                                echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                            }
                        }
                        echo '</span>';
                    ?>
                    <a href="admin_reviews/{{$value->service_id}}" role="button" style="font-weight:bold;">( {{$reviewscount}} Reviews )</a>
                </div>
            </div>
            <div class="card-body">
                <p class="service_description">
                    {{ \Illuminate\Support\Str::limit($value->service_description, 200, $end='...') }}
                </p>
            </div>
            <div class="card-footer">
                <div class="view_details_con">
                    <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#details-{{ $value->service_id }}">
                        View Details
                    </button>
                    <div class="modal fade" id="details-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <!-- Modal -->
                        <div class="modal-dialog" role="document" style="max-width: 70%;">
                            <div class="modal-content service_modal_content">
                                <!-- Modal Content -->
                                <div class="modal-header customer_services_modal_header">
                                    <div class="p-4">
                                        <h4 class="modal_customer_services_title">
                                            <b>{{ $value->service_name }}</b>
                                        </h4>
                                        <div>
                                            <!-- Service Rating -->
                                            <?php
                                                $total = Service_review::where('service_id', $value->service_id)->avg('rate');
                                                $avg = (int)$total;

                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($avg >= $i) {
                                                        echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                    } else {
                                                        echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                    }
                                                }
                                                echo '</span>';
                                            ?>
                                            <a href="admin_reviews/{{$value->service_id}}" role="button" style="font-weight:bold;">( {{$reviewscount}} Reviews )</a>
                                        </div>
                                    </div>
                                    <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="service_description">
                                                {{ $value->service_description }}
                                            </p>
                                            <ul class="package_list">
                                                <li>
                                                    <b>Equipment:</b> <br> {{ $value->equipment }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Materials:</b><br> {{ $value->material }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 price">
                                            <ul class="package_list">
                                                <li>
                                                    <b>Personal Protection:</b> <br>{{ $value->personal_protection }}
                                                </li>
                                            </ul>
                                            <ul class="package_list">
                                                <!-- Retrieve Price Data from Database -->
                                                <?php
                                                    $price_data = Price::Where('service_id', $value->service_id)->get();
                                                ?>
                                                <div class="price">
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
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <!-- Update and Delete a Service -->
                                    <button type="button" data-toggle="modal" data-target="#updateService-{{ $value->service_id }}" class="btn btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#delete-{{ $value->service_id }}" class="btn btn-primary delete_btn" data-dismiss="modal">
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
                        <h5 class="modal-title" id="exampleModalLabel">
                            Delete
                        </h5>
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
                        <button form="delete" type="submit" name="service_id" value="{{$value->service_id}}" class="btn btn-danger">YES</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Updating a Service -->
        <div class="modal fade" id="updateService-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <?php
                $service_data = Service::Where('service_id', $value->service_id)->get();
            ?>
            @foreach($service_data as $key => $value)

            <div class="modal-dialog" role="document" style="max-width: 70%;">
                <div class="modal-content service_modal_content">
                    <div class="modal-header customer_services_modal_header">
                        <div class="p-4">
                            <h4 class="modal_customer_services_title">
                                <b>
                                    Update Service
                                </b>
                            </h4>
                        </div>
                        <button type="button" class="close close-web" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <!-- Form for Updating a Service -->
                        <form action="{{ route('update') }}" method="post">
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
                                        <label class="upload_label">
                                            Service Name
                                        </label>
                                        <input type="text" required class="form-control w-100 add_service_form" id="service_title" name="service_name" placeholder="Service Name" value="{{ old('service_name',$value->service_name) }}">
                                        <span class="text-danger">
                                            @error('service_name'){{ $message }} @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="upload_label">
                                            Description
                                        </label>
                                        <textarea required class="form-control w-100 add_service_form" id="description" name="description" placeholder="Description">{{ $value->service_description }}</textarea>
                                        <span class="text-danger">
                                            @error('description'){{ $message }} @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="upload_label">
                                            Equipments
                                        </label>
                                        <h6 class="desc">
                                            <i>
                                                These are the things used during a service that are not consumable. Eg. Vaccuum Cleaner.
                                            </i>
                                        </h6>
                                        <textarea required class="form-control w-100 add_service_form" id="description" placeholder="Equipments" name="equipment">{{ $value->equipment }}</textarea>
                                        <span class="text-danger">
                                            @error('equipment'){{ $message }} @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="upload_label">
                                            Materials
                                        </label>
                                        <h6 class="desc">
                                            <i>
                                                These are the things used during a service that are consumable. Eg. Soap.
                                            </i>
                                        </h6>
                                        <textarea required class="form-control w-100 add_service_form" id="description" placeholder="Materials" name="material">{{ $value->material }}</textarea>
                                        <span class="text-danger">
                                            @error('material'){{ $message }} @enderror
                                        </span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="upload_label">
                                            Personal Protection
                                        </label>
                                        <h6 class="desc">
                                            <i>
                                                These are neccesary protection for the cleaners for chemicals and particles. Eg. Gloves, Masks.
                                            </i>
                                        </h6>
                                        <textarea required class="form-control w-100 add_service_form" id="description" placeholder="Personal Protection" name="personal_protection">{{ $value->personal_protection }}</textarea>
                                        <span class="text-danger">
                                            @error('personal_protection'){{ $message }} @enderror
                                        </span>
                                    </div>
                                    <?php
                                        $resident_price = Price::Where('service_id', $value->service_id)->Where('property_type', 'Medium-Upper Class Residential Areas')->value('price');
                                        $resident_cleaner = Price::Where('service_id', $value->service_id)->Where('property_type', 'Medium-Upper Class Residential Areas')->value('number_of_cleaner');
                                        $apartment_price = Price::Where('service_id', $value->service_id)->Where('property_type', 'Apartments')->value('price');
                                        $apartment_cleaner = Price::Where('service_id', $value->service_id)->Where('property_type', 'Apartments')->value('number_of_cleaner');
                                        $condo_price = Price::Where('service_id', $value->service_id)->Where('property_type', 'Condominiums')->value('price');
                                        $condo_cleaner = Price::Where('service_id', $value->service_id)->Where('property_type', 'Condominiums')->value('number_of_cleaner');
                                    ?>
                                    <h5 class="pricing_title">
                                        Residential Areas
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="upload_label">
                                                    No. of Cleaners:
                                                </h6>
                                                <div class="form-group">
                                                    <input type="number" required class="form-control w-100 add_service_form" id="service_cleaners" name="resident_number_of_cleaner" placeholder="Residential Areas" value="{{old('resident_number_of_cleaner',$resident_cleaner)}}">
                                                    <span class="text-danger">
                                                        @error('resident_number_of_cleaner'){{ $message }} @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="upload_label">
                                                    Price:
                                                </h6>
                                                <div class="form-group">
                                                    <input type="number" required class="form-control w-100 add_service_form" id="property_residential" name="resident_price" placeholder="Residential Areas" value="{{ old('resident_price', $resident_price) }}">
                                                    <span class="text-danger">
                                                        @error('resident_price'){{ $message }} @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="pricing_title">
                                        Apartments
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="upload_label">
                                                    No. of Cleaners:
                                                </h6>
                                                <div class="form-group">
                                                    <input type="number" required class="form-control w-100 add_service_form" id="service_cleaners" name="apartment_number_of_cleaner" placeholder="Apartments" value="{{old('apartment_number_of_cleaner',$apartment_cleaner )}}">
                                                    <span class="text-danger">
                                                        @error('apartment_number_of_cleaner'){{ $message }} @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="upload_label">
                                                    Price:
                                                </h6>
                                                <div class="form-group">
                                                    <input type="number" class="form-control w-100 add_service_form" id="property_apartment" name="apartment_price" placeholder="Apartments" value="{{ old('apartment_price', $apartment_price) }}">
                                                    <span class="text-danger">
                                                        @error('apartment_price'){{ $message }} @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="pricing_title">
                                        Condominiums
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="upload_label">
                                                    No. of Cleaners:
                                                </h6>
                                                <div class="form-group">
                                                    <input type="number" required class="form-control w-100 add_service_form" id="service_cleaners" name="condo_number_of_cleaner" placeholder="Condominiums" value="{{ old('condo_number_of_cleaner', $condo_cleaner) }}">
                                                    <span class="text-danger">
                                                        @error('condo_number_of_cleaner'){{ $message }} @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="">
                                                <h6 class="upload_label">
                                                    Price:
                                                </h6>
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
                    </div>
                    <div class="modal-footer service_modal_header">
                        <button type="submit" class="btn btn-primary update_btn" class="close-modal">
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

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {

            var result = data.messages;

            Toast.fire({
                animation: true,
                icon: 'success',
                title: JSON.stringify(result),
            })

            var pending = parseInt($('#admin').find('.pending').html());
            if (pending) {
                $('#admin').find('.pending').html(pending + 1);
            } else {
                $('#admin').find('.pending').html(pending + 1);
            }
            $('#refresh').load(window.location.href + " #refresh");
        });
    </script>
<script>

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the words:*/
var material = [
    "Vacuum", "Mop", "Rugs", "Microfiber Cloth", "Duster",
    "Multipurpose Cleaner", "Disinfectant", "Floor Cleaner", "Muriatic Acid",
    "Trash Bag", "Bleach", "Toilet Cleaner", "Degreaser", "Glass cleaner", "Furniture polish",
    "Rubber Gloves", "PPE", "Facemask", "Face Shield", "Sanitizer"
];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("material"), material);
autocomplete(document.getElementById("ppe"), material);
autocomplete(document.getElementById("equipment"), material);
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        No
                    </button>
                    <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection