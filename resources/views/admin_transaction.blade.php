<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Transactions</title>

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
    
    <style>
       
        
       
        
        
        
           
    </style>
</head>
<body class="services-body">
<header>
    <div class="logo"> SWEEP </div>
    <nav>
        <ul>
            <li><a href="admin_dashboard">Home</a></li>
            <li><a href="admin_services">Services</a></li>
            <li><a  class="active" href="admin_transaction">Transaction</a></li>
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
<div class="row"> 
    <a class="usertypebutton" id="active" href="admin_transaction">TRANSACTION <p class="totalvalue">(63)</p></a>
    <a class="usertypebutton" href="admin_transaction_history">HISTORY <p class="totalvalue">(63)</p></a>
</div>
    <div class="search">
        <input class="searchbar" type="text" placeholder="Search..">
        <button class="searchbutton">Search</button>
    </div>
      <p class="show"> Showing 1-10 of 63 results </p>
     <div class="result">
         <p class="show"> Results per page: </p>
         <button class="dropdown"  id="number">10<span class="caret"></span></button>
    </div>
    <div class="services">
        <div class="row row-services">
            <div class="column col-services">
                <div class="card card-services p-4">
                    <div class="d-flex">
                        <i class="bi bi-card-checklist check-icon-1"></i>
                        <h3 class="h3-trans">Light Cleaning</h3>
                        <h5 class="h5-trans">Pending</h5>
                    </div>
                    <div> 
                        <h6 class="h6-trans"><b>Data Created:</b> July 31, 2021</h6>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                <th scope="row">Customer:</th>
                                <td>D. Bondad</td>
                                </tr>
                                <tr>
                                <th scope="row">Address:</th>
                                <td>Palestina Pili Camarines Sur</td>
                                </tr>
                                <tr>
                                <th scope="row">Contact Info:</th>
                                <td>09341562384</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-trans-btn" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check-icon-2"></i>
                                    <h4 class="h4-trans">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                        <li><b>Customer:</b></li>
                                        <li class="list-trans"><b>Name:</b> Duane Xavier Bondad</li>
                                        <li class="list-trans"><b>Contact Number:</b> 09341562384</li>
                                        <li class="list-trans"><b>Address:</b> Palestina Pili Camarines Sur</li>
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list-trans"><b>Date:</b> July 31, 2021</li>
                                        <li class="list-trans"><b>Cleaner/s:</b> 2</li>
                                        <li class="list-trans"><b>Property Type:</b> Apartment</li>
                                        <li class="list-trans"><b>Status:</b> Pending</li>
                                        <li class="list-trans"><b>Price:</b> P376.00</li>
                                                  
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary accept-btn" data-dismiss="modal">ACCEPT</button>
                                    <button type="button" class="btn btn-block btn-primary decline-btn" data-dismiss="modal">DECLINE</button>
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
                        <i class="bi bi-card-checklist check-icon-1"></i>
                        <h3 class="h3-trans">Light Cleaning</h3>
                        <h5 class="h5-trans">Pending</h5>
                    </div>
                    <div> 
                        <h6 class="h6-trans"><b>Data Created:</b> July 31, 2021</h6>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                <th scope="row">Customer:</th>
                                <td>D. Bondad</td>
                                </tr>
                                <tr>
                                <th scope="row">Address:</th>
                                <td>Palestina Pili Camarines Sur</td>
                                </tr>
                                <tr>
                                <th scope="row">Contact Info:</th>
                                <td>09341562384</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-trans-btn" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check-icon-2"></i>
                                    <h4 class="h4-trans">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                        <li><b>Customer:</b></li>
                                        <li class="list-trans"><b>Name:</b> Duane Xavier Bondad</li>
                                        <li class="list-trans"><b>Contact Number:</b> 09341562384</li>
                                        <li class="list-trans"><b>Address:</b> Palestina Pili Camarines Sur</li>
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list-trans"><b>Date:</b> July 31, 2021</li>
                                        <li class="list-trans"><b>Cleaner/s:</b> 2</li>
                                        <li class="list-trans"><b>Property Type:</b> Apartment</li>
                                        <li class="list-trans"><b>Status:</b> Pending</li>
                                        <li class="list-trans"><b>Price:</b> P376.00</li>
                                                  
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary accept-btn" data-dismiss="modal">ACCEPT</button>
                                    <button type="button" class="btn btn-block btn-primary decline-btn" data-dismiss="modal">DECLINE</button>
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
                        <i class="bi bi-card-checklist check-icon-1"></i>
                        <h3 class="h3-trans">Light Cleaning</h3>
                        <h5 class="h5-trans">Pending</h5>
                    </div>
                    <div> 
                        <h6 class="h6-trans"><b>Data Created:</b> July 31, 2021</h6>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                <th scope="row">Customer:</th>
                                <td>D. Bondad</td>
                                </tr>
                                <tr>
                                <th scope="row">Address:</th>
                                <td>Palestina Pili Camarines Sur</td>
                                </tr>
                                <tr>
                                <th scope="row">Contact Info:</th>
                                <td>09341562384</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-trans-btn" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check-icon-2"></i>
                                    <h4 class="h4-trans">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                        <li><b>Customer:</b></li>
                                        <li class="list-trans"><b>Name:</b> Duane Xavier Bondad</li>
                                        <li class="list-trans"><b>Contact Number:</b> 09341562384</li>
                                        <li class="list-trans"><b>Address:</b> Palestina Pili Camarines Sur</li>
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list-trans"><b>Date:</b> July 31, 2021</li>
                                        <li class="list-trans"><b>Cleaner/s:</b> 2</li>
                                        <li class="list-trans"><b>Property Type:</b> Apartment</li>
                                        <li class="list-trans"><b>Status:</b> Pending</li>
                                        <li class="list-trans"><b>Price:</b> P376.00</li>
                                                  
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary accept-btn" data-dismiss="modal">ACCEPT</button>
                                    <button type="button" class="btn btn-block btn-primary decline-btn" data-dismiss="modal">DECLINE</button>
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
                        <i class="bi bi-card-checklist check-icon-1"></i>
                        <h3 class="h3-trans">Light Cleaning</h3>
                        <h5 class="h5-trans">Pending</h5>
                    </div>
                    <div> 
                        <h6 class="h6-trans"><b>Data Created:</b> July 31, 2021</h6>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                <th scope="row">Customer:</th>
                                <td>D. Bondad</td>
                                </tr>
                                <tr>
                                <th scope="row">Address:</th>
                                <td>Palestina Pili Camarines Sur</td>
                                </tr>
                                <tr>
                                <th scope="row">Contact Info:</th>
                                <td>09341562384</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-trans-btn" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check-icon-2"></i>
                                    <h4 class="h4-trans">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                        <li><b>Customer:</b></li>
                                        <li class="list-trans"><b>Name:</b> Duane Xavier Bondad</li>
                                        <li class="list-trans"><b>Contact Number:</b> 09341562384</li>
                                        <li class="list-trans"><b>Address:</b> Palestina Pili Camarines Sur</li>
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list-trans"><b>Date:</b> July 31, 2021</li>
                                        <li class="list-trans"><b>Cleaner/s:</b> 2</li>
                                        <li class="list-trans"><b>Property Type:</b> Apartment</li>
                                        <li class="list-trans"><b>Status:</b> Pending</li>
                                        <li class="list-trans"><b>Price:</b> P376.00</li>
                                                  
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary accept-btn" data-dismiss="modal">ACCEPT</button>
                                    <button type="button" class="btn btn-block btn-primary decline-btn" data-dismiss="modal">DECLINE</button>
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
                        <i class="bi bi-card-checklist check-icon-1"></i>
                        <h3 class="h3-trans">Light Cleaning</h3>
                        <h5 class="h5-trans">Pending</h5>
                    </div>
                    <div> 
                        <h6 class="h6-trans"><b>Data Created:</b> July 31, 2021</h6>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                <th scope="row">Customer:</th>
                                <td>D. Bondad</td>
                                </tr>
                                <tr>
                                <th scope="row">Address:</th>
                                <td>Palestina Pili Camarines Sur</td>
                                </tr>
                                <tr>
                                <th scope="row">Contact Info:</th>
                                <td>09341562384</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-trans-btn" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check-icon-2"></i>
                                    <h4 class="h4-trans">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                        <li><b>Customer:</b></li>
                                        <li class="list-trans"><b>Name:</b> Duane Xavier Bondad</li>
                                        <li class="list-trans"><b>Contact Number:</b> 09341562384</li>
                                        <li class="list-trans"><b>Address:</b> Palestina Pili Camarines Sur</li>
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list-trans"><b>Date:</b> July 31, 2021</li>
                                        <li class="list-trans"><b>Cleaner/s:</b> 2</li>
                                        <li class="list-trans"><b>Property Type:</b> Apartment</li>
                                        <li class="list-trans"><b>Status:</b> Pending</li>
                                        <li class="list-trans"><b>Price:</b> P376.00</li>
                                                  
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary accept-btn" data-dismiss="modal">ACCEPT</button>
                                    <button type="button" class="btn btn-block btn-primary decline-btn" data-dismiss="modal">DECLINE</button>
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
                        <i class="bi bi-card-checklist check-icon-1"></i>
                        <h3 class="h3-trans">Light Cleaning</h3>
                        <h5 class="h5-trans">Pending</h5>
                    </div>
                    <div> 
                        <h6 class="h6-trans"><b>Data Created:</b> July 31, 2021</h6>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                <th scope="row">Customer:</th>
                                <td>D. Bondad</td>
                                </tr>
                                <tr>
                                <th scope="row">Address:</th>
                                <td>Palestina Pili Camarines Sur</td>
                                </tr>
                                <tr>
                                <th scope="row">Contact Info:</th>
                                <td>09341562384</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="view-details">
                        <button type="button" class="btn btn-block btn-primary view-details-trans-btn" data-toggle="modal" data-target="#exampleModalLong10">
                            View Details
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                <div class="d-flex pt-5">
                                    <i class="bi bi-card-checklist check-icon-2"></i>
                                    <h4 class="h4-trans">Light Cleaning</h4>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <ul class="customer_detail">
                                        <li><b>Customer:</b></li>
                                        <li class="list-trans"><b>Name:</b> Duane Xavier Bondad</li>
                                        <li class="list-trans"><b>Contact Number:</b> 09341562384</li>
                                        <li class="list-trans"><b>Address:</b> Palestina Pili Camarines Sur</li>
                                        <br>
                                        <li><b>Service:</b></li>
                                        <li class="list-trans"><b>Date:</b> July 31, 2021</li>
                                        <li class="list-trans"><b>Cleaner/s:</b> 2</li>
                                        <li class="list-trans"><b>Property Type:</b> Apartment</li>
                                        <li class="list-trans"><b>Status:</b> Pending</li>
                                        <li class="list-trans"><b>Price:</b> P376.00</li>
                                                  
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-block btn-primary accept-btn" data-dismiss="modal">ACCEPT</button>
                                    <button type="button" class="btn btn-block btn-primary decline-btn" data-dismiss="modal">DECLINE</button>
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
