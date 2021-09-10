@extends('head_extention_cleaner') 

@section('content')
<head>
<title>
        Cleaner Dashboard
    </title>
    <script type="text/javascript"  id="gwt-pst" src="{{ asset('js/sweep.js')}}"></script>
</head>

<body>
    
    <div class="row cleaner_row_dashboard"> <!-- Sidebar --> 
        <div class="col-sm-3 cleaner_side_con">
            <div class="local_time_con">
                <div id="pst-container">
                    <div class="local_time_title">
                        Philippine Standard Time
                    </div>
                    <div id="pst-time" class="local_time"></div>
                </div>
            </div>
            <h2 class="side_con_title">
                Available Jobs
            </h2>
            <div class="available_job_con"> 
                <div class="arrow_right_con">
                    <a href="#">
                        <span class="right"></span>
                    </a>
                </div>
                <h3 class="service_name">
                    Light Cleaning
                </h3>
                <h6 class="customer_info">
                    <b>Customer:</b> Lyka C. Casilao
                </h6>
                <h6 class="customer_info"> 
                    09341562384
                </h6>
                <h6 class="customer_info">
                    Palestina, Pili, Camarines Sur
                </h6>
            </div> 
        </div>
    </div> <!-- End of Sidebar -->
 
    <div class="customer_adjusted_search_con"> <!-- Search Field -->
        <form action="/action_page.php">
            <input type="text" placeholder="Search" name="search" class="customer_search_field">
        </form>
    </div> <!-- End of Search Field -->
</body>
@endsection