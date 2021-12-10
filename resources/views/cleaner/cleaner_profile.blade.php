<?php

use App\Models\Cleaner;
use App\Models\Address;
?>
@extends('cleaner/cleaner-nav/head_extention_cleaner-profile')

@section('content')

<head>
    <link href="{{ asset('css/cleaner_profile.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>
        Cleaner Profile Page
    </title>
</head>

<body>
    <div class="cleaner_profile_title_con">
        <div>
            <h1 class="cleaner_cards_title">
                My Profile
            </h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="main_profile_con">
            <div class="row justify-content-center">
                <img class="cleaner_profile_avatar_con" src="{{asset('/images/'.$LoggedUserInfo['profile_picture'] ) }}" alt="profile_picture" />
                <div class="cleaner_profile_info_con">
                    <h2 class="cleaner_profile_name" >
                        {{$LoggedUserInfo['full_name']}}
                    </h2>
                </div>
                <div class="cleaner_profile_info_con">
                    <h5 class="cleaner_profile_info">
                        {{$LoggedUserInfo['email']}}
                    </h5>
                </div>
                <div class="cleaner_profile_info_con">
                    <h5 class="cleaner_profile_info">
                        {{$LoggedUserInfo['contact_number']}}
                    </h5>
                </div>

                <?php
                    $cleaner_data = Cleaner::Where('user_id', $LoggedUserInfo['user_id'])->get();
                ?>

                @foreach($cleaner_data as $key => $value)
                <div class="cleaner_profile_info_con">
                    <h5 class="cleaner_profile_info">
                        {{$value->address}}
                    </h5>
                </div>
                <div class="cleaner_profile_info_con">
                    <h5 class="cleaner_profile_info">
                        {{$value->birthday}}
                    </h5>
                </div>
                @endforeach
            </div>
            <div class="modal-footer cleaner_services_modal_footer">
                <button type="button" class="btn btn-block btn-primary book_now_btn" data-dismiss="modal" data-toggle="modal" data-target="#updateProfile">
                    UPDATE
                </button>
                <a class="btn btn-block btn-primary logout_btn" data-dismiss="modal" data-toggle="modal" data-target="#logout" >LOGOUT</a>
            </div>

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
                            <!-- Form for Updating a Profile -->
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
                                @foreach($cleaner_data as $key => $value)
                                <input type="hidden" class="form-control w-100 add_service_form" id="user_id" name="user_id" value="{{$LoggedUserInfo['user_id']}}">
                                <div class="form-group">
                                    <input type="text" class="form-control w-100 add_service_form" id="full_name" name="full_name" placeholder="Full Name" value="{{ old('full_name',$LoggedUserInfo['full_name']) }}" required>
                                    <span class="text-danger">
                                        @error('full_name'){{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control w-100 add_service_form" id="email" name="email" placeholder="Email" value="{{ old('email',$LoggedUserInfo['email']) }}" required>
                                    <span class="text-danger">
                                        @error('email'){{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control w-100 add_service_form" id="contact_number" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number',$LoggedUserInfo['contact_number']) }}" required>
                                    <span class="text-danger">
                                        @error('contact_number'){{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control w-100 add_service_form" id="address" name="address" placeholder="Address" value="{{ old('address',$value->address) }}" required>
                                    <span class="text-danger">
                                        @error('address'){{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control w-100 add_service_form" id="birthday" name="birthday" placeholder="Birthday" value="{{ old('birthday',$value->birthday) }}" required>
                                    <span class="text-danger">
                                        @error('birthday'){{ $message }} @enderror
                                    </span>
                                </div>
                            
                        </div>
                        <div class="modal-footer service_modal_header">
                            <button type="submit" class="btn btn-primary update_btn" class="close-modal">
                                UPDATE
                            </button>
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">
                                CANCEL
                            </button>
                        </div>
                        </form>
                    </div>
                @endforeach
                </div>
            </div> 
        </div>
    </div>
    
    <!-- Success Popup -->
    @if(!empty(Session::get('success')))
    <script>
        swal({
            title: "Your Profile has been Updated!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Fail Popup -->
    @if(!empty(Session::get('fail')))
    <script>
        swal({
            title: "Something went wrong, try again!",
            icon: "error",
            button: "Close",
        });
    </script>
    @endif

    <!-- Logout Popup Modal -->
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
    <!-- Mobile -->
    <div class="mobile-spacer">
    </div>
    <!-- Footer -->
    <footer id="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </footer>
</body>
@endsection