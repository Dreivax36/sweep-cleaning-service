<div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
    @forelse ($notif as $notification)
                              
    <a class="dropdown-item read" id="{{$notification->id}}" style="background-color:#f2f3f4; border:1px solid #dcdcdc" href="{{$notification->location}}">
        {{ $notification->message}}
    </a>
                               
    @empty
    <a class="dropdown-item">
        No record found
    </a>
    @endforelse
</div>