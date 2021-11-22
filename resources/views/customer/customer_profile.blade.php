<?php
    use App\Models\Customer;
    use App\Models\Address;
?>
@extends('customer/customer-nav/head_extention_customer-user') 

@section('content')
<head>
    <link href="{{ asset('css/customer_profile.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>
        Customer Profile Page
    </title>
</head>

<body>
    <div class="customer_profile_title_con">
        <div>
            <h1 class="customer_cards_title">
                My Profile
            </h1> 
        </div>
    </div>
    <!-- Display Customer profile -->
    <div class="row justify-content-center">
        <div class="main_profile_con">
            <div class="row justify-content-center">
                <img class="customer_profile_avatar_con" src="{{asset('/images/'.$LoggedUserInfo['profile_picture'] ) }}" alt="profile_picture" />
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
                    $addressCount = Address::Where('customer_id', $customer_id )->count();
                ?>
                @foreach($address_data as $key => $value)
                    <div class="customer_profile_info_con">
                        <h5 class="customer_profile_info">
                            {{$value->address}}
                        </h5>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer customer_services_modal_footer">
                <button type="button" class="btn btn-block btn-primary book_now_btn" data-dismiss="modal" data-toggle="modal" data-target="#updateProfile-{{ $value->customer_id }}">
                    UPDATE
                </button>
                @if ($addressCount > 1)
                <button type="button" class="btn btn-block btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#delete-{{ $value->customer_id }}">
                    DELETE ADDRESS
                </button>
                @endif
                <a class="btn btn-block btn-primary logout_btn" data-dismiss="modal" data-toggle="modal" data-target="#logout">LOGOUT</a>
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
                        <!-- Form for Updating a profile -->
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
                                <input type="text" class="form-control w-100 add_service_form" id="full_name" name="full_name" placeholder="Full Name" value="{{ $LoggedUserInfo['full_name'] }}" required>
                                <span class="text-danger">
                                    @error('full_name'){{ $message }} @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control w-100 add_service_form" id="email" name="email" placeholder="Email" value="{{ $LoggedUserInfo['email'] }}" required>
                                <span class="text-danger">
                                    @error('email'){{ $message }} @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control w-100 add_service_form" id="contact_number" name="contact_number" placeholder="Contact Number" value="{{ $LoggedUserInfo['contact_number'] }}" required>
                                <span class="text-danger">
                                    @error('contact_number'){{ $message }} @enderror
                                </span>
                            </div>
                            @foreach($address_data as $key => $value)
                            <div class="form-group">
                            <input type="hidden" id="address" name="address_id[]"  value="{{ old('address',$value->address_id) }}">
                                <input type="text" class="form-control w-100 add_service_form" id="address" name="address[]" placeholder="Address" value="{{ $value->address }}" required>
                                <span class="text-danger">
                                    @error('address'){{ $message }} @enderror
                                </span>
                            </div>
                            @endforeach
                        </form>
                    </div>
                    <div class="modal-footer service_modal_header">
                        <button form="update" type="submit" class="btn btn-primary update_btn">
                            UPDATE
                        </button>
                        <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">
                            CANCEL
                        </button>
                    </div>
                </div>  
            </div>
        </div> <!-- End of Modal for Updating a Profile -->

        <!-- Modal for Deleting a address -->
        <div class="modal fade" id="delete-{{ $value->customer_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content service_modal_content">
                    <div class="modal-header service_modal_header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Delete Address
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>
                            Address: 
                        </h5>
                        <select class="form-control" name="address_id[]"  id="address_id[]">
                            @foreach($address_data as $key => $value)
                                <option value="{{$value->address_id}}">{{$value->address}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer service_modal_header">
                        <button form="delete" id="submit" class="btn btn-primary update_btn" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirm-{{ $value->customer_id }}">
                            DELETE
                        </button>
                        <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">
                            CANCEL
                        </button>
                    </div>  
                </div>  
            </div>
        </div> 

        <!-- Modal for delete address confimation-->
        <div class="modal fade" id="deleteConfirm-{{ $value->customer_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to delete address -->
                        <form action="{{ route('deleteAddress') }}" method="post" id="delete">
                            @if(Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success-delete') }}
                                </div>
                            @endif
                            @if(Session::get('fail'))
                                <div class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                </div>
                            @endif
                            @csrf

                            Are you sure you want to delete an address?
                            <input type="hidden" name="address_id" id="address_id" value="">
                        </form> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button form="delete" type="submit"  class="btn btn-danger">YES</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Store the address temporary and pass it to delete confirmation modal-->
    <script type="text/javascript">
        $("#submit").click(function () {
            const id = document.getElementById('address_id[]').value;
            document.getElementById("address_id").value = id;
        });
    </script>

    <!-- Popup when success -->
    @if(!empty(Session::get('success')))
    <script>
        swal({
            title: "Your Profile has been Updated!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when fail -->
    @if(!empty(Session::get('fail')))
    <script>
        swal({
            title: "Something went wrong, try again!",
            icon: "error",
            button: "Close",
        });
    </script>
    @endif
    <!-- Popup when delete success -->
    @if(!empty(Session::get('success-delete')))
    <script>
        swal({
            title: "Address successfully deleted!",
            icon: "success",
            button: "Close",
        });
    </script>
    @endif

    <!-- Modal for logout -->
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
                    <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div class="mobile-spacer">
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </div>
</body>
@endsection


