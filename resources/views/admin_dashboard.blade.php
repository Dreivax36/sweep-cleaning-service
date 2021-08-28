@extends('head_extention_admin') 

@section('content')
    <title>
        Admin Dashboard Page
    </title>

<body>
  <header> <!-- Navbar -->
        <div class="logo"> 
          SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a href="admin_dashboard" class="active">
                        Home
                    </a>
                </li>
                <li>
                    <a href="admin_services">
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

  <div class="row row_dashboard"> 
    <div class="col-sm-3 col_dashboard_main">  <!-- Sidebar -->
      <h2 class="dashboard_title"> 
        Active Transactions
      </h2>
      <div class="active_services_con"> 
        <div class="arrow_right_con">
          <a href="#">
            <span class="right"></span>
          </a>
        </div>
        <h3 class="service_name"> 
          Light Cleaning 
        </h3>
        <p class="transaction_id"> 
          Trans ID: 20201211AC56205 
        </p>
        <p class="customer_name"> 
          Customer: Lyka C. Casilao 
        </p>
      </div> 
      <div class="active_services_con"> 
        <div class="arrow_right_con">
          <a href="#">
            <span class="right"></span>
          </a>
        </div>
        <h3 class="service_name"> 
          Light Cleaning 
        </h3>
        <p class="transaction_id"> 
          Trans ID: 20201211AC56205 
        </p>
        <p class="customer_name"> 
          Customer: Lyka C. Casilao 
        </p>      
      </div> 
      <div class="active_services_con"> 
        <div class="arrow_right_con">
          <a href="#">
            <span class="right"></span>
          </a>
          </div>
          <h3 class="service_name"> 
            Light Cleaning 
          </h3>
          <p class="transaction_id"> 
            Trans ID: 20201211AC56205 
          </p>
          <p class="customer_name"> 
            Customer: Lyka C. Casilao 
          </p>    
      </div> 
      <div class="active_services_con"> 
        <div class="arrow_right_con">
          <a href="#">
            <span class="right"></span>
          </a>
          </div>
          <h3 class="service_name"> 
            Light Cleaning 
          </h3>
          <p class="transaction_id"> 
            Trans ID: 20201211AC56205 
          </p>
          <p class="customer_name"> 
            Customer: Lyka C. Casilao 
          </p>     
      </div> 
    </div> <!-- End of Sidebar -->

    <div class="col-sm-9">
      <div class="adjust_con"> <!-- Search Field -->
            <input class="searchbar" type="search" placeholder="Search..">
            <button class="search_btn">
              Search
            </button>
      </div> <!-- End of Search Field -->
     
      <div class="row" id="report"> <!-- Reports -->
        <div class="daily_revenue">
          <h3 class="value">
            2,873 php 
            </h3>
          <p class="report_title">
            Daily Revenue 
          </p>
        </div>
        <div class="weekly_revenue">
          <h3 class="value"> 
            17,243 php 
          </h3>
          <p class="report_title"> 
            Weekly Revenue 
          </p>
        </div>
        <div class="sweep_user">
          <h3 class="value"> 
            103 
          </h3>
          <p class="report_title"> 
            Sweep Users 
          </p>
        </div>
        <div class="sweep_cleaner">
          <h3 class="value"> 
            21 
          </h3>
          <p class="report_title"> 
            Sweep Cleaners 
          </p>
        </div>
      </div> <!-- End of Reports -->
     
      <div class="container my-3">
        <div id="calendar"></div>
      </div>      
      <div class="row" id="daily_transaction">
        <div class="container">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>
  </div>

<!-- Bar Graph -->
<script>
  let myChart = document.getElementById('myChart').getContext('2d');
  let massPopChart = new Chart(myChart, {
    type: 'bar',
    data:{
      labels:[['Light', 'Cleaning'], ['Deep', 'Cleaning'], ['Deep Kitchen', 'Cleaning'], ['Upholstery', 'Cleaning'], ['Sanitation and Germ', 'Proofing'], ['Maid for', 'a Day']],
      datasets:[{
        label:'On-Progress', 
        data:[
          5,
          2,
          4,
          2,
          2,
          3
        ],
        backgroundColor:'#219EBC'
      }, {
        label:'Done', 
        data:[
          2,
          3,
          4,
          1,
          3,
          2
        ],
        backgroundColor:'#FB8500'
      }]
    },
    options:{
      title:{
        display:true,
        text:'Sweep Daily Transaction',
        fontSize:25,
        fontColor: "#000000" 
      },
      legend:{
        position:'right',
        labels:{
        fontColor:'#219EBC'
        }
      },
      layout:{
        padding: {
          left:50,
          right:0,
          bottom:0,
          top:0
        }
      },
      tooltips:{
        enabled:true
      }
    }
  });
</script>

</body>
@endsection








<!-- Calendar 
  <script src="https://unpkg.com/jquery@3.4.1/dist/jquery.min.js"></script>
  <script src="https://unpkg.com/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
  <script src="fullcalendar/4.4.0/core/main.min.js"></script>
  <script src="fullcalendar/4.4.0/daygrid/main.min.js"></script>
  <script src="fullcalendar/4.4.0/bootstrap/main.min.js"></script>
  <script>
    var el = document.getElementById('calendar');
    var calendar = new fullcalendar.Calendar(el, {
      plugins: ['dayGrid', 'bootstrap'],
      themeSystem: 'bootstrap', 
      weekNumbers: true,
      eventLimit: true,
      events: [{
        title: 'your title',
        start: '2020-03-12',
        end: '2020-03-15'
      }]
    })
    calendar.render();
    </script>-->