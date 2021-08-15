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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
</head>
<body >
<header>
    <div class="logo"> SWEEP </div>
    <nav>
        <ul>
            <li><a  href="admin_dashboard">Home</a></li>
            <li><a  href="admin_services">Services</a></li>
            <li><a class="active" href="admin_transaction">Transaction</a></li>
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
    <a class="usertypebutton"  href="admin_transaction">TRANSACTION <p class="totalvalue">(63)</p></a>
    <a class="usertypebutton" id="active" href="admin_transaction_history">HISTORY <p class="totalvalue">(63)</p></a>
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
    <div class="trans-his">
        <table class=" table table-responsive-md table-hover">
        <thead class="row-title">
            <tr class="table-trans-his">
            <th scope="col">Customer Name</th>
            <th scope="col">Service Name</th>
            <th scope="col">Property Type</th>
            <th scope="col">Service Fee</th>
            <th scope="col">Mode of Payment</th>
            <th scope="col">Cleaner ID</th>
            <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-trans-his">
            <th>Leah L. Cortez</th>
            <td>Light Cleaning</td>
            <td>Apartments </td>
            <td>P342.00</td>
            <td>GCash</td>
            <td>CL001, CL002</td>
            <td>Completed</td>
            </tr>
            <tr class="table-trans-his">
            <th>Leah L. Cortez</th>
            <td>Light Cleaning</td>
            <td>Apartments </td>
            <td>P342.00</td>
            <td>GCash</td>
            <td>CL001, CL002</td>
            <td>Completed</td>
            </tr>
            <tr class="table-trans-his">
            <th>Leah L. Cortez</th>
            <td>Light Cleaning</td>
            <td>Apartments </td>
            <td>P342.00</td>
            <td>GCash</td>
            <td>CL001, CL002</td>
            <td>Completed</td>
            </tr>
            <tr class="table-trans-his">
            <th>Leah L. Cortez</th>
            <td>Light Cleaning</td>
            <td>Apartments </td>
            <td>P342.00</td>
            <td>GCash</td>
            <td>CL001, CL002</td>
            <td>Completed</td>
            </tr>
            <tr class="table-trans-his">
            <th>Leah L. Cortez</th>
            <td>Light Cleaning</td>
            <td>Apartments </td>
            <td>P342.00</td>
            <td>GCash</td>
            <td>CL001, CL002</td>
            <td>Completed</td>
            </tr>
        </tbody>
        </table>
    </div>



</body>