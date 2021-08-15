 <!DOCTYPE html>
<html lang="en">
<head>
  <title>SWEEP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="fullcalendar/4.4.0/core/main.min.css">
  <link rel="stylesheet" href="fullcalendar/4.4.0/daygrid/main.min.css">
  <link rel="stylesheet" href="fullcalendar/4.4.0/bootstrap/main.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
</head>

<body>
<!-- Navbar -->  
<header>
    <div class="logo"> SWEEP </div>
    <nav>
        <ul>
            <li><a  class="active" href="admin_dashboard">Home</a></li>
            <li><a href="admin_services">Services</a></li>
            <li><a href="admin_transaction">Transaction</a></li>
            <li><a href="admin_user">User</a></li>
            <li><a href="admin_payroll">Payroll</a></li>
            <div class="profile_button" style="margin-left: 315px; margin-top: 8px;">
                <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                    <img class="profile" src="{{ asset('images/profile-icon-white-7.png') }}">
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
    <div class="col-sm-3">
      <!-- Side Bar -->
      <h2 class="label"> Active Transactions </h2>
      <div class="activeservices"> 
            <div class="arrowright">
              <a href="#">
                <span class="right"></span>
              </a>
            </div>
            <h3 class="servicename"> Light Cleaning </h3>
            <p class="transactionid"> Trans ID: 20201211AC56205 </p>
            <p class="customername"> Customer: Lyka C. Casilao </p>
      </div> 
      <div class="activeservices"> 
            <div class="arrowright">
              <a href="#">
                <span class="right"></span>
              </a>
            </div>
            <h3 class="servicename"> Light Cleaning </h3>
            <p class="transactionid"> Trans ID: 20201211AC56205 </p>
            <p class="customername"> Customer: Lyka C. Casilao </p>
            
      </div> 
      <div class="activeservices"> 
            <div class="arrowright">
              <a href="#">
                <span class="right"></span>
              </a>
            </div>
            <h3 class="servicename"> Light Cleaning </h3>
            <p class="transactionid"> Trans ID: 20201211AC56205 </p>
            <p class="customername"> Customer: Lyka C. Casilao </p>
            
      </div> 
      <div class="activeservices"> 
            <div class="arrowright">
              <a href="#">
                <span class="right"></span>
              </a>
            </div>
            <h3 class="servicename"> Light Cleaning </h3>
            <p class="transactionid"> Trans ID: 20201211AC56205 </p>
            <p class="customername"> Customer: Lyka C. Casilao </p>
            
      </div> 
    </div>
    <div class="col-sm-9">
      <div class="adjust">
         <div class="search">
          <input class="searchbar" type="text" placeholder="Search..">
          <button class="searchbutton">Search</button>
      </div>
    </div>
        <!-- Reports -->
      <div class="row" id="report">
        <div class="dailyrevenue">
          <h3 class="value"> 2,873 php </h3>
          <p class="reporttitle"> Daily Revenue </p>
        </div>
        <div class="weeklyrevenue">
          <h3 class="value"> 17,243 php </h3>
          <p class="reporttitle"> Weekly Revenue </p>
        </div>
        <div class="sweepuser">
          <h3 class="value"> 103 </h3>
          <p class="reporttitle"> Sweep Users </p>
        </div>
        <div class="sweepcleaner">
          <h3 class="value"> 21 </h3>
          <p class="reporttitle"> Sweep Cleaners </p>
        </div>
      </div>

        <div class="container my-3">
          <div id="calendar"></div>
      </div>      <div class="row" id="dailytransaction">
          <div class="container">
            <canvas id="myChart"></canvas>
          </div>
      </div>
    </div>
  </div>

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
