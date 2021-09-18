<?php
    use App\Models\cleaner;
?>
@extends('head_extention_cleaner') 

@section('content')
    <title>
        Cleaner Profile Page
    </title>
    <link href="{{ asset('css/style_cleaner.css') }}" rel="stylesheet">
<body>

    <div class="col-2 d-flex cleaner_profile_title_con">
        <div>
            <h1 class="cleaner_cards_title">
                My Profile
            </h1> 
        </div>
    </div>
    <div class="main_profile_con d-flex">
        <div class="cleaner_profile_con">
            <div class="card cleaner_profile_avatar_con">
            <img class="card-img-top profile_avatar_img" src="{{asset('/images/'.$LoggedUserInfo['profile_picture'] ) }}" alt="profile_picture" />
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="p-2 cleaner_profile_name_con">
                <h2 class="cleaner_profile_name">
                {{$LoggedUserInfo['full_name']}}
                </h2>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5 class="cleaner_profile_info">
                {{$LoggedUserInfo['email']}}
                </h5>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <h5 class="cleaner_profile_info">
                {{$LoggedUserInfo['contact_number']}}
                </h5>
            </div>
            <?php
                $address = Cleaner::Where('user_id', $LoggedUserInfo['user_id'] )->value('address');
                $age = Cleaner::Where('user_id', $LoggedUserInfo['user_id'] )->value('age');
            ?>

            
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <h5 class="cleaner_profile_info">
                {{$address}}
                </h5>
            </div>
            <div class="d-flex p-3 cleaner_profile_info_con">
                <div class="cleaner_profile_info_icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <h5 class="cleaner_profile_info">
                {{$age}}
                </h5>
            </div>
        </div>
        
        <div class="update_btn_con"> <!-- Update Button -->
            <button type="button" class="btn btn-link customer_update_btn" data-toggle="modal" data-target="#updateProfile">
                UPDATE
            </button>
        </div> <!-- End of Update Button -->
        <!-- Modal for Updating a Profile -->
        <div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content service_modal_content">
                    <div class="modal-header service_modal_header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Update Profile
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    
                <!-- Form for Updating a Service -->
                <form action="{{ route('updateCleaner') }}" method="post" id="update">
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if(Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    @csrf
                    <input type="hidden" class="form-control w-100 add_service_form" id="user_id" name="user_id" value="{{$LoggedUserInfo['user_id']}}">    
                    <div class="form-group">
                        <input type="text" class="form-control w-100 add_service_form" id="full_name" name="full_name" placeholder="Full Name" value="{{ old('full_name',$LoggedUserInfo['full_name']) }}">
                        <span class="text-danger">
                            @error('full_name'){{ $message }} @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control w-100 add_service_form" id="email" name="email" placeholder="Email" value="{{ old('email',$LoggedUserInfo['email']) }}">
                        <span class="text-danger">
                            @error('email'){{ $message }} @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control w-100 add_service_form" id="contact_number" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number',$LoggedUserInfo['contact_number']) }}">
                        <span class="text-danger">
                            @error('contact_number'){{ $message }} @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control w-100 add_service_form" id="address" name="address" placeholder="Address" value="{{ old('address',$address) }}">
                        <span class="text-danger">
                            @error('address'){{ $message }} @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control w-100 add_service_form" id="age" name="age" placeholder="Age" value="{{ old('age',$age) }}">
                        <span class="text-danger">
                            @error('age'){{ $message }} @enderror
                        </span>
                    </div>
                    
                </form>
                
                </div>
                    <div class="modal-footer service_modal_header">
                        <button form="update" type="submit" class="btn btn-primary update_btn" class="close-modal">
                            UPDATE
                        </button>
                        <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">
                            CANCEL
                        </button>
                    </div>
                </div>
               
            </div>
        </div> <!-- End of Modal for Updating a Service -->
    </div>
</body>
@endsection