<?php
    use App\Models\Service;
    use App\Models\Price;
?>

@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Services Page
    </title>

<body>
    <header> <!-- Navbar -->
        <div class="logo"> SWEEP </div>
        <nav>
            <ul>
                <li>
                    <a href="admin_dashboard">
                        Home
                    </a>
                </li>
                <li>
                    <a href="admin_services" class="active">
                        Services
                    </a>
                </li>
                <li>
                    <a href="admin_transaction">
                        Transaction
                    </a>
                </li>
                <li>
                    <a href="admin_user">
                        User
                    </a>
                </li>
                <li>
                    <a href="admin_payroll">
                        Payroll
                    </a>
                </li>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img class="profile_img" src="/img/user.png">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            Logout
                        </a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar -->

    <div class="search_con"> <!-- Search Field -->
        <input class="searchbar" type="text" placeholder="Search..">
        <button class="search_btn">
            Search
        </button>
    </div> <!-- End of Search Field -->
    
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
                <div class="modal-dialog" role="document">
                    <div class="modal-content service_modal_content">
                    <div class="modal-header service_modal_header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            New Service
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('addService') }}" method="post" id="myform">
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
                            <button form="myform" type="submit" class="btn btn-primary update_btn">
                                ADD
                            </button>
                            <button type="button" class="btn btn-block btn-primary delete_btn">
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
    @foreach($service_data as $key => $value)

    <div class="services_con">
        <div class="row row_services">
            <div class="column col_services"> <!-- Light Cleaning -->
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            Light Cleaning
                        </h3>
                    </div>
                    <div>
                        <p class="service_description">
                            The light cleaning service comprises sweeping and mopping the floors, dusting appliances and cupboards, wiping down countertops, disposing of waste, and performing simple disinfection. This service will ensure that your home is clear of dust, filth, and debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong1">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content-->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        Light Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        The light cleaning service comprises sweeping and mopping the floors, dusting appliances and cupboards, wiping down countertops, disposing of waste, and performing simple disinfection. This service will ensure that your home is clear of dust, filth, and debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.
                                        </li>
                                        <li>
                                            <b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.
                                        </li>
                                        <li>
                                            <b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer.
                                        </li>
                                        <li>
                                            <b>Cleaners:</b> 3 Cleaners
                                        </li>
                                        <br>
                                        <li>
                                            <b>Medium-Upper Class Residential Areas</b>
                                        </li>
                                        <li>
                                            <b>Price: P 545.00</b>
                                        </li>
                                        <br> 
                                        <li>
                                            <b>Apartments</b>
                                        </li>
                                        <li>
                                            <b>Price: P 342.00</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Condominiums</b>
                                        </li>
                                        <li>
                                            <b>Price: P 356.00</b>
                                        </li>          
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div> <!-- End of Light Cleaning -->
            
            <div class="column col_services"> <!-- Deep Kitchen Cleaning -->
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            Deep Kitchen Cleaning
                        </h3>
                    </div>
                    <div>
                        <p class="service_description">
                            This service is designed exclusively for the kitchen, focusing on deep cleaning the countertops, stovetops, and ovens. Additionally, the service includes utensils and materials management.  Dishwashing is not included.
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong3">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content-->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        Deep Kitchen Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service is designed exclusively for the kitchen, focusing on deep cleaning the countertops, stovetops, and ovens. Additionally, the service includes utensils and materials management.  Dishwashing is not included.
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.
                                        </li>
                                        <li>
                                            <b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.
                                        </li>
                                        <li>
                                            <b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer.
                                        </li>
                                        <li>
                                            <b>Cleaners:</b> 3 Cleaners
                                        </li>
                                        <br>
                                        <li>
                                            <b>Medium-Upper Class Residential Areas</b>
                                        </li>
                                        <li>
                                            <b>Price: P 560.00</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Apartments</b>
                                        </li>
                                        <li>
                                            <b>Price: P 376.00 (Can be Marked up to P 380.00)</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Condominiums</b>
                                        </li>
                                        <li>
                                            <b>Price: P 391.00 (Can be Marked up to P 395.00)</b>
                                        </li>          
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content-->
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div> <!-- End of Deep Kitchen Cleaning -->
            
            <div class="column col_services"> <!-- Upholstery Cleaning -->
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            Upholstery Cleaning
                        </h3>
                     </div>
                    <div>
                        <p class="service_description">
                            This service will concentrate on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance. It is recommended to perform this procedure at least once every three months.
                        </p>
                    </div>
                    <div class="view_details">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong4">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content-->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        Upholstery Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service will concentrate on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance. It is recommended to perform this procedure at least once every three months.
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.
                                        </li>
                                        <li>
                                            <b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.
                                        </li>
                                        <li>
                                            <b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer
                                        </li>
                                        <li>
                                            <b>Cleaners:</b> 3 Cleaners
                                        </li>
                                        <br>
                                        <li>
                                            <b>Medium-Upper Class Residential Areas</b>
                                        </li>
                                        <li>
                                            <b>Price: P 560.00</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Apartments</b>
                                        </li>
                                        <li>
                                            <b>Price: P 357.00 (Can be marked up to P 360.00)</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Condominiums</b>
                                        </li>
                                        <li>
                                            <b>Price: P 371.00 (Can be marked up to P 375.00)</b>
                                        </li>          
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->   
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div> <!-- End of Upholstery Cleaning -->
           
            <div class="column col_services"> <!-- Maid for a Day -->
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            Maid for a Day
                        </h3>
                    </div>
                    <div>
                        <p class="service_description">
                            This service will provide a worry-free day in the house by having a maid take care of the essential household chores. This service specializes in light dry cleaning, with a focus on simple kitchen and bathroom cleaning and organizing, dishwashing, laundry and ironing as well as modest bedroom organization. The service will last eight hours and will include between one and two maids, depending on the size of the residence. The customer is responsible for providing both equipment and materials.
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong5">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content-->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        Maid for a Day
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service will provide a worry-free day in the house by having a maid take care of the essential household chores. This service specializes in light dry cleaning, with a focus on simple kitchen and bathroom cleaning and organizing, dishwashing, laundry and ironing as well as modest bedroom organization. The service will last eight hours and will include between one and two maids, depending on the size of the residence. The customer is responsible for providing both equipment and materials.
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Medium-Upper Class Residential Areas</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 1 Cleaner (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 8 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 780.00</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 2 Cleaners (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 8 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 1350.00</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li>
                                            <b>Working Hours:</b> 4 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 442.00 (can be marked up to P 450.00)</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 2 Cleaners (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 4 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 780.00</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Apartments</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 1 Cleaner (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 8 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 720.00</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 2 Cleaners (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 8 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 1248.00 (Can be marked up to P 1250.00)</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 1 Cleaner (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 4 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 408.00 (can be marked up to P 410.00)</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 2 Cleaners (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 4 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 720.00</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Condominiums</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 1 Cleaner (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 8 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 750.00</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 2 Cleaners (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 8 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 1300.00 (Can be marked up to P 1250.00)</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 1 Cleaner (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 4 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 425.00</b>
                                        </li>
                                        <li>
                                            <b>Number of Cleaners:</b> 2 Cleaners (Customizable)
                                        </li>
                                        <li>
                                            <b>Working Hours:</b> 4 Hours
                                        </li>
                                        <li>
                                            <b>Price: P 750.00</b>
                                        </li>        
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content -->    
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div> <!-- End of Maid for a Day --> 
           
            <div class="column col_services"> <!-- Deep Home Cleaning -->
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            Deep Home Cleaning
                        </h3>
                    </div>
                    <div>
                        <p class="service_description">
                            A deeper dive into maintaining a clean environment, this service will include sweeping/vacuuming and mopping the floors, vacuuming carpets, dusting cabinets, wiping down countertops, bathroom cleaning, waste disposal, and wiping down windows, ceilings, lighting fixtures, and walls, as well as simple disinfection. It is recommended to perform this procedure at least once a month.
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong2">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content-->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        Deep Home Cleaning
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        A deeper dive into maintaining a clean environment, this service will include sweeping/vacuuming and mopping the floors, vacuuming carpets, dusting cabinets, wiping down countertops, bathroom cleaning, waste disposal, and wiping down windows, ceilings, lighting fixtures, and walls, as well as simple disinfection. It is recommended to perform this procedure at least once a month.
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.
                                        </li>
                                        <li>
                                            <b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.
                                        </li>
                                        <li>
                                            <b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer.
                                        </li>
                                        <li>
                                            <b>Cleaners:</b> 3 Cleaners
                                        </li>
                                        <br>
                                        <li>
                                            <b>Medium-Upper Class Residential Areas</b>
                                        </li>
                                        <li>
                                            <b>Price: P 600.00 (can be marked up to P 610.00)</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Apartments</b>
                                        </li>
                                        <li>
                                            <b>Price: P 391.00 (Can be marked up to P 395.00)</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Condominiums</b>
                                        </li>
                                        <li>
                                            <b>Price: P 407.00 (Can be marked up to P 410.00)</b>
                                        </li>          
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div>  <!-- End of Modal Content --> 
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div> <!-- End of Deep Home Cleaning -->
           
            <div class="column col_services"> <!-- Sanitation and Germ Proofing -->
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            Sanitation and Germ Proofing
                        </h3>
                    </div>
                    <div>
                        <p class="service_description">
                            This service will emphasize thorough sanitation, which will include disinfectant spray and antimicrobial fogging. It is recommended to perform this procedure at least once a month.
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong6">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content-->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        Sanitation and Germ Proofing
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service will emphasize thorough sanitation, which will include disinfectant spray and antimicrobial fogging. It is recommended to perform this procedure at least once a month.
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Medium-Upper Class Residential Areas</b>
                                        </li>
                                        <li>
                                            <b>Price: P 580.00</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Apartments</b>
                                        </li>
                                        <li>
                                            <b>Price: P 355.00 (Can be Marked Up to P 360.00))</b>
                                        </li>
                                        <br>
                                        <li>
                                            <b>Condominiums</b>
                                        </li>
                                        <li>
                                            <b>Price: P 369.00 (Can be Marked Up to P 375.00)</b>
                                        </li>          
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <button type="button" class="btn btn-block btn-primary update_btn" data-dismiss="modal">
                                        UPDATE
                                    </button>
                                    <button type="button" class="btn btn-block btn-primary delete_btn" data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content --> 
                            </div>
                        </div> <!-- End of Modal --> 
                    </div>
                </div>
            </div> <!-- End of Sanitation and Germ Proofing -->
       
            <div class="column col_services">
                <div class="card card_services p-4">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="broom_img p-1">
                        <h3 class="service_title">
                            {{ $value->service_name }}
                        </h3>
                    </div>
                    <div>
                        <p class="service_description">
                            {{ $value->service_description }}
                        </p>
                    </div>
                    <div class="view_details_con">
                        <button type="button" class="btn btn-block btn-primary view_details_btn" data-toggle="modal" data-target="#exampleModalLong1">
                            View Details
                        </button>
                        <div class="modal fade" id="exampleModalLong1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 service_modal_content"> <!-- Modal Content -->
                                <div class="modal-header service_modal_header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom_img_inside p-1">
                                    <h4 class="modal_service_title">
                                        {{ $value->service_name }}
                                    </h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        {{ $value->service_description }}
                                    </p>
                                    <ul class="package_list">
                                        <li>
                                            <b>Equipment:</b>{{ $value->equipment }}
                                        </li>
                                        <li>
                                            <b>Materials:</b>{{ $value->material }}
                                        </li>
                                        <li>
                                            <b>Personal Protection:</b>{{ $value->personal_protection }}
                                        </li>
                                        <br>
                                        
                                        <!-- Retrieve Price Data from Database -->
                                        <?php 
                                            $price_data = Price::Where('service_id', $value->service_id )->get();
                                        ?>
                                        @foreach($price_data as $key => $value)
                                            <li>
                                                <b>{{ $value->property_type }}</b>
                                            </li>
                                            <li>
                                                <b>{{ $value->price }}</b>
                                            </li>
                                            <li>
                                                <b>Cleaners:</b>{{ $value->number_of_cleaner }}
                                            </li>
                                            <br>
                                        @endforeach     
                                    </ul>
                                </div>
                                <div class="modal-footer service_modal_footer">
                                    <!-- Update and Delete a Service -->
                                    <button type="button" data-toggle="modal" data-target="#updateService-{{ $value->service_id }}" class="btn btn-block btn-primary update_btn" class="close-modal">
                                        UPDATE
                                    </button>
                                    @method('DELETE')
                                    <button type="button" onclick='return confirm("Are you sure?")' href="{{ route('destroy', $value->service_id) }}" class="btn btn-block btn-primary delete_btn"  data-dismiss="modal">
                                        DELETE
                                    </button>
                                </div>
                            </div> <!-- End of Modal Content --> 
                            </div>
                        </div> <!-- End of Modal -->
                    </div>
                </div>
            </div>
            
            <!-- Modal for Updating a Service -->
            <div class="modal fade" id="updateService-{{ $value->service_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            
                <?php
                    $service_data = Service::Where('service_id', $value->service_id )->get();
                ?>
                @foreach($service_data as $key => $value)
 
                <div class="modal-dialog" role="document">
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
                    </form>
                    </div>
                        <div class="modal-footer service_modal_header">
                            <button form="update" type="submit" class="btn btn-primary update_btn" class="close-modal">
                                UPDATE
                            </button>
                            <button type="button" class="btn btn-block btn-primary delete_btn" class="close" data-dismiss="modal">
                                CANCEL
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div> <!-- End of Modal for Updating a Service -->
            @endforeach
        </div>
    </div>
</body>
@endsection
