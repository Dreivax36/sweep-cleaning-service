<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Services</title>

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">

</head>
<body>
<header>
    <div class="logo"> SWEEP </div>
    <nav>
        <ul>
            <li><a  href="admin_dashboard">Home</a></li>
            <li><a class="active" href="admin_services">Services</a></li>
            <li><a href="admin_transaction">Transaction</a></li>
            <li><a href="admin_user">User</a></li>
            <li><a href="admin_payroll">Payroll</a></li>
            <div class="profile_button" style="margin-left: 315px; margin-top: 8px;">
                <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                    <img class="profile" src="{{ asset('images/profile-icon-white-7.png') }}">
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
    <div class="search">
        <input class="searchbar" type="text" placeholder="Search..">
        <button class="searchbutton">Search</button>
    </div>
    <div class="col-2 d-flex heading-title">
        <div>
            <h1 class="h1_services">SERVICES</h1> 
        </div>
        <div class="add-service">
            <button type="button" class="btn btn-block btn-primary add-service-btn" data-toggle="modal" data-target="#addservice">
                + Add Service
            </button>
        </div>
    </div>
    <div class="services">
        <div class="row row-services">
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom p-1">
                        <h3 class="service_title">Light Cleaning</h3>
                    </div>
                    <div>
                        <p class="service_description">
                            The light cleaning service comprises sweeping and mopping the floors, dusting appliances and cupboards, wiping down countertops, disposing of waste, and performing simple disinfection. This service will ensure that your home is clear of dust, filth, and debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                        </p>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-btn" data-toggle="modal" data-target="#exampleModalLong1">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4 class="modal_service_title">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        The light cleaning service comprises sweeping and mopping the floors, dusting appliances and cupboards, wiping down countertops, disposing of waste, and performing simple disinfection. This service will ensure that your home is clear of dust, filth, and debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                                    </p>
                                    <ul class="package">
                                        <li><b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.</li>
                                        <li><b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.</li>
                                        <li><b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer</li>
                                        <li><b>Cleaners:</b> 3 Cleaners</li>
                                        <br>
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Price: P 545.00</b></li>
                                        <br>  
                                        <li><b>Apartments</b></li>
                                        <li><b>Price: P 342.00</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Price: P 356.00</b></li>          
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom p-1">
                        <h3>Deep Kitchen Cleaning</h3>
                    </div>
                    <div>
                        <p class="service_description">
                            This service is designed exclusively for the kitchen, focusing on deep cleaning the countertops, stovetops, and ovens. Additionally, the service includes utensils and materials management.  Dishwashing is not included.
                        </p>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-btn" data-toggle="modal" data-target="#exampleModalLong3">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4>Deep Kitchen Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service is designed exclusively for the kitchen, focusing on deep cleaning the countertops, stovetops, and ovens. Additionally, the service includes utensils and materials management.  Dishwashing is not included.
                                    </p>
                                    <ul class="package">
                                        <li><b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.</li>
                                        <li><b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.</li>
                                        <li><b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer</li>
                                        <li><b>Cleaners:</b> 3 Cleaners</li>
                                        <br>
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Price: P 560.00</b></li>
                                        <br>
                                        <li><b>Apartments</b></li>
                                        <li><b>Price: P 376.00 (Can be Marked up to P 380.00)</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Price: P 391.00 (Can be Marked up to P 395.00)</b></li>          
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom p-1">
                        <h3>Upholstery Cleaning</h3>
                     </div>
                    <div>
                        <p class="service_description">
                            This service will concentrate on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance. It is recommended to perform this procedure at least once every three months.
                        </p>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-btn" data-toggle="modal" data-target="#exampleModalLong4">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4>Upholstery Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service will concentrate on cleaning your sofas, pillows, and mattresses in order to eliminate accumulated dust and debris and restore their original appearance. It is recommended to perform this procedure at least once every three months.
                                    </p>
                                    <ul class="package">
                                        <li><b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.</li>
                                        <li><b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.</li>
                                        <li><b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer</li>
                                        <li><b>Cleaners:</b> 3 Cleaners</li>
                                        <br>
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Price: P 560.00</b></li>
                                        <br>
                                        <li><b>Apartments</b></li>
                                        <li><b>Price: P 357.00 (Can be marked up to P 360.00)</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Price: P 371.00 (Can be marked up to P 375.00)</b></li>          
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom p-1">
                        <h3>Maid for a Day</h3>
                    </div>
                    <div>
                        <p class="service_description">
                            This service will provide a worry-free day in the house by having a maid take care of the essential household chores. This service specializes in light dry cleaning, with a focus on simple kitchen and bathroom cleaning and organizing, dishwashing, laundry and ironing as well as modest bedroom organization. The service will last eight hours and will include between one and two maids, depending on the size of the residence. The customer is responsible for providing both equipment and materials.
                        </p>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-btn" data-toggle="modal" data-target="#exampleModalLong5">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4>Maid for a Day</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service will provide a worry-free day in the house by having a maid take care of the essential household chores. This service specializes in light dry cleaning, with a focus on simple kitchen and bathroom cleaning and organizing, dishwashing, laundry and ironing as well as modest bedroom organization. The service will last eight hours and will include between one and two maids, depending on the size of the residence. The customer is responsible for providing both equipment and materials.
                                    </p>
                                    <ul class="package">
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li><b>Working Hours:</b> 8 Hours</li>
                                        <li><b>Price: P 780.00</b></li>
                                        <li><b>Number of Cleaners:</b> 2 Cleaners (Customizable)</li>
                                        <li><b>Working Hours:</b> 8 Hours</li>
                                        <li><b>Price: P 1350.00</b></li>
                                        <li><b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li><b>Working Hours:</b> 4 Hours</li>
                                        <li><b>Price: P 442.00 (can be marked up to P 450.00)</b></li>
                                        <li><b>Number of Cleaners:</b> 2 Cleaners (Customizable)</li>
                                        <li><b>Working Hours:</b> 4 Hours</li>
                                        <li><b>Price: P 780.00</b></li>
                                        <br>
                                        <li><b>Apartments</b></li>
                                        <li><b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li><b>Working Hours:</b> 8 Hours</li>
                                        <li><b>Price: P 720.00</b></li>
                                        <li><b>Number of Cleaners:</b> 2 Cleaners (Customizable)</li>
                                        <li><b>Working Hours:</b> 8 Hours</li>
                                        <li><b>Price: P 1248.00 (Can be marked up to P 1250.00)</b></li>
                                        <li><b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li><b>Working Hours:</b> 4 Hours</li>
                                        <li><b>Price: P 408.00 (can be marked up to P 410.00)</b></li>
                                        <li><b>Number of Cleaners:</b> 2 Cleaners (Customizable)</li>
                                        <li><b>Working Hours:</b> 4 Hours</li>
                                        <li><b>Price: P 720.00</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li><b>Working Hours:</b> 8 Hours</li>
                                        <li><b>Price: P 750.00</b></li>
                                        <li><b>Number of Cleaners:</b> 2 Cleaners (Customizable)</li>
                                        <li><b>Working Hours:</b> 8 Hours</li>
                                        <li><b>Price: P 1300.00 (Can be marked up to P 1250.00)</b></li>
                                        <li><b>Number of Cleaners:</b> 1 Cleaner (Customizable)</li>
                                        <li><b>Working Hours:</b> 4 Hours</li>
                                        <li><b>Price: P 425.00</b></li>
                                        <li><b>Number of Cleaners:</b> 2 Cleaners (Customizable)</li>
                                        <li><b>Working Hours:</b> 4 Hours</li>
                                        <li><b>Price: P 750.00</b></li>        
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom p-1">
                        <h3>Deep Home Cleaning</h3>
                    </div>
                    <div>
                        <p class="service_description">
                            A deeper dive into maintaining a clean environment, this service will include sweeping/vacuuming and mopping the floors, vacuuming carpets, dusting cabinets, wiping down countertops, bathroom cleaning, waste disposal, and wiping down windows, ceilings, lighting fixtures, and walls, as well as simple disinfection. It is recommended to perform this procedure at least once a month.
                        </p>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-btn" data-toggle="modal" data-target="#exampleModalLong2">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4>Deep Home Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        A deeper dive into maintaining a clean environment, this service will include sweeping/vacuuming and mopping the floors, vacuuming carpets, dusting cabinets, wiping down countertops, bathroom cleaning, waste disposal, and wiping down windows, ceilings, lighting fixtures, and walls, as well as simple disinfection. It is recommended to perform this procedure at least once a month.
                                    </p>
                                    <ul class="package">
                                        <li><b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.</li>
                                        <li><b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.</li>
                                        <li><b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer</li>
                                        <li><b>Cleaners:</b> 3 Cleaners</li>
                                        <br>
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Price: P 600.00 (can be marked up to P 610.00)</b></li>
                                        <br>
                                        <li><b>Apartments</b></li>
                                        <li><b>Price: P 391.00 (Can be marked up to P 395.00)</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Price: P 407.00 (Can be marked up to P 410.00)</b></li>          
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <img src="/images/broom.png" class="broom p-1">
                        <h3>Sanitation and Germ Proofing</h3>
                    </div>
                    <div>
                        <p class="service_description">
                            This service will emphasize thorough sanitation, which will include disinfectant spray and antimicrobial fogging. It is recommended to perform this procedure at least once a month.
                        </p>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-btn" data-toggle="modal" data-target="#exampleModalLong6">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4>Sanitation and Germ Proofing</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        This service will emphasize thorough sanitation, which will include disinfectant spray and antimicrobial fogging. It is recommended to perform this procedure at least once a month.
                                    </p>
                                    <ul class="package">
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Price: P 580.00</b></li>
                                        <br>
                                        <li><b>Apartments</b></li>
                                        <li><b>Price: P 355.00 (Can be Marked Up to P 360.00))</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Price: P 369.00 (Can be Marked Up to P 375.00)</b></li>          
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <img src="/images/broom.png" class="broom-2 p-1">
                                    <h4 class="modal_service_title">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="service_description">
                                        The light cleaning service comprises sweeping and mopping the floors, dusting appliances and cupboards, wiping down countertops, disposing of waste, and performing simple disinfection. This service will ensure that your home is clear of dust, filth, and debris. Additionally, be virus and bacteria-free. Daily/weekly service is recommended.
                                    </p>
                                    <ul class="package">
                                        <li><b>Equipment:</b> Vacuum, Mop, Rugs, Microfiber Cloth, Duster.</li>
                                        <li><b>Materials:</b> Multipurpose Cleaner, Disinfectant, Floor Cleaner, Trash Bag, Bleach.</li>
                                        <li><b>Personal Protection:</b> Rubber Gloves, PPE, Facemask, Face Shield, Sanitizer</li>
                                        <li><b>Cleaners:</b> 3 Cleaners</li>
                                        <br>
                                        <li><b>Medium-Upper Class Residential Areas</b></li>
                                        <li><b>Price: P 545.00</b></li>
                                        <br>  
                                        <li><b>Apartments</b></li>
                                        <li><b>Price: P 342.00</b></li>
                                        <br>
                                        <li><b>Condominiums</b></li>
                                        <li><b>Price: P 356.00</b></li>          
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">UPDATE</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">DELETE</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Add service Modal -->
                        <div class="modal fade" id="addservice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <h4>Add Service</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                <form action="" method="post">
                                   
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="service_name" placeholder="Service Name" value="{{ old('email') }}">
                                        <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="service_description" placeholder="Service Description">
                                        <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                                    </div>
                                    <div class="d-flex pt-5">
                                    <h4>Pricing</h4>
                                     </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="service_description" placeholder="Medium-Upper Class Residential Areas">
                                        <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="service_description" placeholder="Apartments">
                                        <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="service_description" placeholder="Condominiums">
                                        <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary update-btn" data-dismiss="modal">ADD</button>
                                    <button type="button" class="btn btn-block btn-primary delete-btn" data-dismiss="modal">CANCEL</button>
                                </div>
                            </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
