<?php
    use App\Models\Customer;
    use App\Models\Address;
?>
@extends('customer/customer-nav/head_extention_customer-user') 

@section('content')
<head>
    <link href="{{ asset('css/customer_profile.css') }}" rel="stylesheet">
    <title>
        Customer Profile Page
    </title>
</head>
<body>
    

    <div class="customer_profile_title_con">
        <div>
            <h1 class="customer_cards_title">
                
            </h1> 
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="main_profile_con">
            <div class="row justify-content-center">
                <div class="profile_avatar_con">
                    <img class="customer_profile_avatar_con" src="{{asset('/images/'.$LoggedUserInfo['profile_picture'] ) }}" alt="profile_picture" />
                </div>
                <div class="customer_profile_info_con">
                    <h2 class="customer_profile_name" >
                        {{$LoggedUserInfo['full_name']}}
                    </h2>
                </div>
                <div class="customer_profile_info_con">
                    <h5 class="customer_profile_info">
                    {{$LoggedUserInfo['email']}}
                    </h5>
                </div>
                <div class="customer_profile_info_con">
                    <h5 class="customer_profile_info">
                        {{$LoggedUserInfo['contact_number']}}
                    </h5>
                </div>

                <?php
                    $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
                    $address_data = Address::Where('customer_id', $customer_id )->get();
                ?>

                @foreach($address_data as $key => $value)
                <div class="customer_profile_info_con">
                    <h5 class="customer_profile_info">
                        {{$value->address}}
                    </h5>
                </div>

            </div>
            <div class="modal-footer customer_services_modal_footer">
                <button type="button" class="btn btn-block btn-primary book_now_btn" data-dismiss="modal" data-toggle="modal" data-target="#updateProfile-{{ $value->customer_id }}">
                    UPDATE
                </button>
                <a class="btn btn-block btn-primary logout_btn" href="{{ route('auth.logout') }}">LOGOUT</a>
                
            </div>

            
            <!-- Modal for Updating a Profile -->
            <div class="modal fade" id="updateProfile-{{ $value->customer_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form action="{{ route('updateProfile') }}" method="post" id="update">
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
                            <input type="text" class="form-control w-100 add_service_form" id="address" name="address" placeholder="Address" value="{{ old('address',$value->address) }}">
                            <span class="text-danger">
                                @error('address'){{ $message }} @enderror
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
                    @endforeach
                </div>
            </div> <!-- End of Modal for Updating a Profile -->
        </div>
    </div>
    <div class="mobile-spacer">

    </div>
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
</div>
</body>
@endsection