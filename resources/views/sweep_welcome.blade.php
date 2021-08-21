<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome</title>

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_welcome.css')}}">
</head>
<body>
    <!-- Navbar -->  
    <header>
        <div class="logo"> SWEEP </div>
        <nav>
            <ul>
                <li><a class="active nav_con" href="admin_dashboard">Home</a></li>
                <li><a class="nav_con" href="admin_services">Services</a></li>
                <li><a class="nav_con" href="admin_transaction">Contact Us</a></li>
                <li><a class="nav_con" href="admin_user">FAQs</a></li>
                <li><a class="nav_con" href="admin_payroll">About Us</a></li>
                
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header>
    <div class="welcome_con">
        <div class="welcome_title_con">
            <h1 class="welcome_title">The Road to Cleanliness has never been easier.</h1>
        </div>
        <div class="welcome_sub_con">
            <h5 class="welcome_sub">Making your comfort zones squeaky clean one step at a time.</h5>
        </div>
        <div class="signup_con">
            <a class="register_link_btn" href="{{ route('customer.customer_login') }}"> Login as Customer</a><br>
            <a class="register_link_btn" href="{{ route('cleaner.cleaner_login') }}"> Login as Cleaner</a><br>
            <a class="register_link_btn" href="{{ route('auth.login') }}"> Login as Admin</a>
        </div>
    </div>
    <div class="fixed_footer">
        <div class="footer_content">Copyright &copy; 2021 Ateneo de Naga University</div>        
    </div>
</body>
</html>