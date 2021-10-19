<?php 
    use App\Models\Notification;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="{{ asset('js/sweep.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav-cleaner.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light sweep-nav shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brandname" href="{{ url('/cleaner/cleaner_dashboard') }}">
                SWEEP
            </a>
            <li class="nav-item dropdown bell" id="cleaner">
                <!-- Notification data -->
                <?php
                    $notifCount = Notification::where('isRead', false)->where('user_id',  $LoggedUserInfo['user_id'] )->count();
                    $notif = Notification::where('isRead', false)->where('user_id',  $LoggedUserInfo['user_id'] )->get();
                ?>      
                            
                <a id="navbarDropdown cleaner" class="nav-link"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fa fa-bell"></i> 
                    @if($notifCount != 0)
                        <span class="badge alert-danger pending">{{$notifCount}}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">    
                    @forelse ($notif as $notification)
                        <a class="dropdown-item read" id="refresh" style="background-color:#f2f3f4; border:1px solid #dcdcdc" href="/{{$notification->location}}/{{$notification->id}}">
                            {{ $notification->message}}
                        </a>                          
                    @empty
                        <a class="dropdown-item">
                            No record found
                        </a>
                    @endforelse
                </div>
            </li>
            <ul class="navbar-nav ml-auto">
                <a href="{{ url('/cleaner/cleaner_dashboard') }}" class="nav-link">Home</a>
                <a id="service" class="nav-link active" href="{{ url('/cleaner/cleaner_job') }}" role="button">Jobs</a>
                <a id="history" class="nav-link" href="{{ url('/cleaner/cleaner_history') }}" role="button">History</a>
                <!-- Notification Data -->
                <li class="nav-item dropdown" id="cleaner">
                    <?php
                        $notifCount = Notification::where('isRead', false)->where('user_id',  $LoggedUserInfo['user_id'] )->count();
                        $notif = Notification::where('isRead', false)->where('user_id',  $LoggedUserInfo['user_id'] )->get();
                    ?>      
                    <a id="navbarDropdown cleaner" class="nav-link"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-bell"></i> 
                        @if($notifCount != 0)
                            <span class="badge alert-danger pending">{{$notifCount}}</span>
                        @endif
                    </a>    
                    <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                        @forelse ($notif as $notification)
                            <a class="dropdown-item read" id="refresh" style="background-color:#f2f3f4; border:1px solid #dcdcdc" href="/{{$notification->location}}/{{$notification->id}}">
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
                        <a class="dropdown-item" href="cleaner_profile">
                            Profile
                        </a>
                        <a class="dropdown-item" data-dismiss="modal" data-toggle="modal" data-target="#logout">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
            <!-- Mobile Navbar -->
            <ul class="mobile-nav sticky-bottom">
                <a class="nav-button" href="{{ url('/cleaner/cleaner_dashboard') }}">
                    <i class="fas fa-home"></i>
                    <h6>Home</h6>
                </a>
                <a class="nav-button active" href="{{ url('/cleaner/cleaner_jobs') }}">
                    <i class="fas fa-hand-sparkles fas-active"></i>
                    <h6>Jobs</h6>
                </a>
                <a class="nav-button" href="{{ url('/cleaner/cleaner_history') }}">
                    <i class="fas fa-history"></i>
                    <h6>History</h6>
                </a>
                <a class="nav-button" href="cleaner_profile">
                    <i class="fas fa-user-circle"></i>
                    <h6>Profile</h6>
                </a>
            </ul>
        </div>
    </nav>

    <!-- Logout modal -->
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
                        Are you sure you want to Logout?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" onclick="document.location='{{ route('logout_cleaner') }}'">Yes</button>
                </div>
            </div>
        </div>
    </div>    

    <main>
        @yield('content')
    </main>

    <script>
    // Enable pusher logging 
    Pusher.logToConsole = true;

    var pusher = new Pusher('21a2d0c6b21f78cd3195', {
    cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
        channel.bind('cleaner-notif', function(data) {
        
        var id = "{{ $LoggedUserInfo['user_id'] }}";
        if(data.id == id){
            var pending = parseInt($('#cleaner').find('.pending').html());
             //Trigger and add notification in badge
            if(pending) {
                $('#cleaner').find('.pending').html(pending + 1);
            }else{
                $('#cleaner').find('.pending').html(pending + 1);
            } 
            //Reload notification
            $('#refresh').load(window.location.href + " #refresh");
            //Reload transaction card to update status and the button
            $('#status').load(window.location.href + " #status");
        }
        });
    </script>

</body>