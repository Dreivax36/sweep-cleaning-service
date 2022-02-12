<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
?>

@extends('customer/customer-nav/head_extention_customer-history')

@section('content')

<head>
    <link href="{{ asset('css/customer_trans.css') }}" rel="stylesheet">
    <title>
        Customer History Page
    </title>
</head>

<body>
    <div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
                    HISTORY
                </h1>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="pagination justify-content-center">
        </div>
        <!-- Get the Transaction with the status of Completed, Done, Declined and Cancelled -->
        <div class="card-content row justify-content-center">
            <?php
                $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'])->value('customer_id');
                $customerCount = Booking::Where('customer_id', $customer_id)->Where('status', '!=', 'Pending')->Where('status', '!=', 'Accepted')->Where('status', '!=', 'On-Progress')->Where('status', '!=', 'Done')->count();
                $booking_data = Booking::Where('customer_id', $customer_id)->Where('status', '!=', 'Pending')->Where('status', '!=', 'Accepted')->Where('status', '!=', 'On-Progress')->Where('status', '!=', 'Done')->orderBy('updated_at','DESC')->get();
            ?>
            @if($customerCount == 0)
            <div class="banner-container">
                <div class="banner">
                    <div class="text">
                        <h1> 
                            You currently have no history.
                        </h1>
                    </div>
                    <div class="image">
                        <img src="/images/services/header_img.png" class="img-fluid">
                    </div>
                </div>
            </div>
            @endif
            <!-- Transaction Details -->
            @if($booking_data != null)
            @foreach($booking_data as $key => $value)
            <?php
                $booking_id = Booking::where('booking_id', $value->booking_id)->value('booking_id');
                $service_data = Service::Where('service_id', $value->service_id)->get();
                $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->get();
            ?>
            <div class="card  mb-3" style="width: 25rem;">
                <div class="row no-gutters">
                    @foreach($service_data as $key => $data)
                    @foreach($price as $key => $price_data)
                    <div class="card-body">
                        <div class="status">
                            <h5 class="customer_trans_status">
                                {{ $value->status }}
                            </h5>
                        </div>
                        <div class="card_body">
                            <h3 class="service_title_trans">
                                {{ $data->service_name }}
                            </h3>
                        </div>
                        <div>
                            <h6 class="booking_date">
                                <b>Transaction ID:</b> {{ $booking_id }}
                            </h6>
                        </div>
                        <table class="table table-striped user_info_table">
                            <tbody>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Schedule:
                                    </th>
                                    <td class="user_table_data">
                                        {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Property:
                                    </th>
                                    <td class="user_table_data">
                                        {{ $value->property_type}}
                                    </td>
                                </tr>
                                <tr class="user_table_row">
                                    <th scope="row" class="user_table_header">
                                        Price:
                                    </th>
                                    <td class="user_table_data">
                                        ₱{{ $price_data->price }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="buttons">
                            <div class="byt float-right">
                                <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->booking_id }}">
                                    DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for transaction details -->
                <div class="modal fade" id="exampleModalLong10-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content p-4 customer_trans_modal_content">
                            <div class="modal-header customer_trans_modal_header">
                                <img src="/img/broom.png" class="customer_trans_broom_2_1_img p-1">
                                <div class="d-flex flex-column">
                                    <h4 class="customer_trans_modal_title">
                                        {{ $data->service_name}}
                                    </h4>
                                    <h6 class="customer_trans_modal_date_1_1">
                                        {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                    </h6>
                                    <h6 class="customer_trans_modal_amount_1">
                                        Total Amount: ₱{{ $price_data->price }}
                                    </h6>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body d-flex p-4">
                                <div class="customer_trans_modal_body_1_con">
                                    <p class="customer_trans_description">
                                        {{ $data->service_description}}
                                    </p>
                                    <ul class="customer_package_list">
                                        <li>
                                            <b>
                                                Equipment:
                                            </b> {{ $data->equipment }}
                                        </li>
                                        <br>
                                        <li>
                                            <b>
                                                Materials:
                                            </b> {{ $data->material }}
                                        </li>
                                        <br>
                                        <li>
                                            <b>
                                                Personal Protection:
                                            </b> {{ $data->personal_protection }}
                                        </li>
                                        <br>
                                        <li>
                                            <b>
                                                Property Type:
                                            </b> {{ $value->property_type }}
                                        </li>
                                        <!-- Get assigned cleaner/s for that transaction -->
                                        <?php
                                            $id = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                        ?>
                                        <br>
                                        <li>
                                            <b>
                                                Cleaners:
                                            </b>
                                        </li>
                                        @if($id != null)
                                            @foreach($id as $cleaner)
                                            <?php
                                                $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id)->value('user_id');
                                                $full = User::Where('user_id', $user_id)->value('full_name');
                                            ?>
                                            <li class="list_booking_info">
                                                <b>
                                                    Name:
                                                </b> {{ $full }}
                                            </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End of Modal -->
                @endforeach
                @endforeach
            </div>
            @endforeach
            @endif
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

<!-- Pagination Scripts -->
<script type="text/javascript">
    function getPageList(totalPages, page, maxLength) {
        function range(start, end) {
            return Array.from(Array(end - start + 1), (_, i) => i + start);
        }

        var sideWidth = maxLength < 9 ? 1 : 2;
        var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
        var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

        if (totalPages <= maxLength) {
            return range(1, totalPages);
        }

        if (page <= maxLength - sideWidth - 1 - rightWidth) {
            return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
        }

        if (page >= totalPages - sideWidth - 1 - rightWidth) {
            return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
        }

        return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
    }

    $(function() {
        var numberOfItems = $(".card-content .card").length;
        var limitPerPage = 10; //How many card items visible per a page
        var totalPages = Math.ceil(numberOfItems / limitPerPage);
        var paginationSize = 7; //How many page elements visible in the pagination
        var currentPage;

        function showPage(whichPage) {
            if (whichPage < 1 || whichPage > totalPages) return false;

            currentPage = whichPage;

            $(".card-content .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

            $(".pagination li").slice(1, -1).remove();

            getPageList(totalPages, currentPage, paginationSize).forEach(item => {
                $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
                    .toggleClass("active1", item === currentPage).append($("<a>").addClass("page-link")
                        .attr({
                            href: "javascript:void(0)"
                        }).text(item || "...")).insertBefore(".next-page");
            });

            $(".previous-page").toggleClass("disable", currentPage === 1);
            $(".next-page").toggleClass("disable", currentPage === totalPages);
            return true;
        }

        $(".pagination").append(
            $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({
                href: "javascript:void(0)"
            }).text("Prev")),
            $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({
                href: "javascript:void(0)"
            }).text("Next"))
        );

        $(".card-content").show();
        showPage(1);

        $(document).on("click", ".pagination li.current-page:not(.active1)", function() {
            return showPage(+$(this).text());
        });

        $(".next-page").on("click", function() {
            return showPage(currentPage + 1);
        });

        $(".previous-page").on("click", function() {
            return showPage(currentPage - 1);
        });
    });
</script>
@endsection