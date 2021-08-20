<!DOCTYPE html>
<html lang="en">
<head>
  <title>SWEEP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
</head>

<body>
<!-- Navbar -->  
<header>
    <div class="logo"> SWEEP </div>
    <nav>
        <ul>
            <li><a href="admin_dashboard">Home</a></li>
            <li><a href="admin_services">Services</a></li>
            <li><a href="admin_transaction">Transaction</a></li>
            <li><a  class="active" href="admin_user">User</a></li>
            <li><a href="admin_payroll">Payroll</a></li>
            <div class="profile_button" style="margin-left: 315px; margin-top: 8px;">
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

<div class="row"> 
    <a class="usertypebutton" href="admin_user">ALL <p class="totalvalue">(63)</p></a>
    <a class="usertypebutton"  href="admin_customer">CUSTOMER <p class="totalvalue">(63)</p></a>
    <a class="usertypebutton" id="active" href="admin_cleaner">CLEANER <p class="totalvalue">(63)</p></a>
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

<div class="usertable">
    <div class="tabledetail">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th class="text-center">Full Name</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Email Address</th>
                    <th class="text-center">Contact Number</th>
                    <th class="text-center">Valid ID</th>
                    <th class="text-center">Requirement</th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="verifybutton">VERIFY</button>
                    </td>
                </tr>
               
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
            $('.menu-toggle').click(function(){
                $('nav').toggleClass('active')
            })
        })
</script>

</body>
</html>
