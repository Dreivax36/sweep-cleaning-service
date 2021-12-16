<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
    use App\Models\Review;
    use App\Models\Service_review;
    use App\Models\Cleaner_review;
?>
@extends('cleaner/cleaner-nav/head_extention_cleaner-history')

@section('content')
<title>
    Cleaner History Page
</title>
<link href="{{ asset('css/cleaner_history.css') }}" rel="stylesheet">
<style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

    
        .pagination{
        text-align: center;
        margin: 30px 30px 60px;
        user-select: none;
        }

        .pagination li{
        display: inline-block;
        margin: 5px;
        box-shadow: 0 5px 25px rgb(1 1 1 / 10%);
        }

        .pagination .page-item a{
        color: #fff;
        text-decoration: none;
        font-size: 1.2em;
        line-height: 45px;
        }

        .previous-page, .next-page{
        background: #0AB1CE;
        width: 80px;
        border-radius: 45px;
        cursor: pointer;
        transition: 0.3s ease;
        }

        .previous-page:hover{
        transform: translateX(-5px);
        }

        .next-page:hover{
        transform: translateX(5px);
        }

        .current-page, .dots{
        background: #ccc;
        width: 45px;
        border-radius: 50%;
        cursor: pointer;
        }

        .active1{
        background: #0AB1CE;
        }

        .disable{
        background: #ccc;
        }
     </style>   

<body>
    <div class="jobs">
        <h1 class="cleaner_cards_title">
            History
        </h1>
    </div>
    <div class="body">
        <div class="card-content row justify-content-center">
        <div class="pagination">
          <!--<li class="page-item previous-page disable"><a class="page-link" href="#">Prev</a></li>
          <li class="page-item current-page active"><a class="page-link" href="#">1</a></li>
          <li class="page-item dots"><a class="page-link" href="#">...</a></li>
          <li class="page-item current-page"><a class="page-link" href="#">5</a></li>
          <li class="page-item current-page"><a class="page-link" href="#">6</a></li>
          <li class="page-item dots"><a class="page-link" href="#">...</a></li>
          <li class="page-item current-page"><a class="page-link" href="#">10</a></li>
          <li class="page-item next-page"><a class="page-link" href="#">Next</a></li>-->
        </div>
        <!-- Get job history - status with completed, declined, cancelled -->
        <?php
          $userID = User::Where('email', 'duanexcleaner@gmail.com')->value('user_id');
          $cleanerID = Cleaner::Where('user_id', $userID)->value('cleaner_id');           
          $cleanerCount = Assigned_cleaner::Where('cleaner_id', $cleanerID)->where('status', 'Declined')->orwhere('status', 'Completed')->orwhere('status', 'Cancelled')->count();
            $bookingID = Assigned_cleaner::Where('cleaner_id', $cleanerID)->orderBy('updated_at','DESC')->get();
        ?>
        <!-- No history display this -->
        @if($cleanerCount == 0)
        <div class="banner-container">
            <div class="banner1">
                <div class="text">
                    <h1> You currently have no history.</h1>
                </div>
                <div class="image">
                    <img src="/images/services/header_img.png" class="img-fluid">
                </div>

            </div>
        </div>
        @endif
        @if($bookingID != null)
        @foreach($bookingID as $key => $booking)
        <!-- Get transaction equal to the transaction assigned -->
        @if($booking->status == 'Declined')
        <?php
            $booking_data = Booking::Where('booking_id', $booking->booking_id)->get();
        ?>
        @else
        <?php
            $booking_data = Booking::Where('booking_id', $booking->booking_id)->Where('status', 'Completed')->orWhere('status', 'Cancelled')->orderBy('updated_at','DESC')->get();
        ?>
        @endif
        
        @foreach($booking_data as $key => $value)
        <!-- Check the transaction if it is equal to the transaction in assigned cleaner table  -->
        @if($booking->booking_id == $value->booking_id || $booking->status == 'Declined')
        <?php
            $booking_id = Booking::where('booking_id', $booking->booking_id)->value('booking_id');
            $serviceName = Service::Where('service_id', $value->service_id)->value('service_name');
            $userID = Customer::Where('customer_id', $value->customer_id)->value('user_id');
            $user_data = User::Where('user_id', $userID)->get();
            $address = Address::Where('customer_id', $value->customer_id)->value('address');
            $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->get();
        ?>

        <div class="card job" style="width: 25rem;">
            <div class="card-body">
                @if ($booking->status != 'Declined' || $booking->status != 'Cleaner-no-response' )
                <h5 class="cleaner_job_status float-right">
                    {{ $value->status }}
                </h5>
                @else
                <h5 class="cleaner_job_status float-right">
                    {{ $booking->status }}
                </h5>
                @endif
                <div class="d-flex card_body">
                    <i class="fas fa-clipboard-list"></i>
                    <h3 class="service_title_trans">
                        {{ $serviceName}}
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
                            @foreach($user_data as $key => $user)
                            <th scope="row" class="user_table_header">
                                Customer:
                            </th>
                            <td class="user_table_data">
                                {{ $user->full_name }}
                            </td>
                            @endforeach
                        </tr>
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
                            @foreach($price as $key => $price_data)
                            <td class="user_table_data">
                            ₱{{ $price_data->price }} 
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="buttons">
                    <button type="button" class="btn btn-block btn-primary view_details_btn_trans" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                        View Details
                    </button>
                </div>
            </div>
        </div>
            @endforeach
            @endif
            @endforeach
            @endforeach
            @endif
   
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
<script type="text/javascript">
function getPageList(totalPages, page, maxLength){
  function range(start, end){
    return Array.from(Array(end - start + 1), (_, i) => i + start);
  }

  var sideWidth = maxLength < 9 ? 1 : 2;
  var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
  var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

  if(totalPages <= maxLength){
    return range(1, totalPages);
  }

  if(page <= maxLength - sideWidth - 1 - rightWidth){
    return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
  }

  if(page >= totalPages - sideWidth - 1 - rightWidth){
    return range(1, sideWidth).concat(0, range(totalPages- sideWidth - 1 - rightWidth - leftWidth, totalPages));
  }

  return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
}

$(function(){
  var numberOfItems = $(".card-content .card").length;
  var limitPerPage = 3; //How many card items visible per a page
  var totalPages = Math.ceil(numberOfItems / limitPerPage);
  var paginationSize = 7; //How many page elements visible in the pagination
  var currentPage;

  function showPage(whichPage){
    if(whichPage < 1 || whichPage > totalPages) return false;

    currentPage = whichPage;

    $(".card-content .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

    $(".pagination li").slice(1, -1).remove();

    getPageList(totalPages, currentPage, paginationSize).forEach(item => {
      $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
      .toggleClass("active1", item === currentPage).append($("<a>").addClass("page-link")
      .attr({href: "javascript:void(0)"}).text(item || "...")).insertBefore(".next-page");
    });

    $(".previous-page").toggleClass("disable", currentPage === 1);
    $(".next-page").toggleClass("disable", currentPage === totalPages);
    return true;
  }

  $(".pagination").append(
    $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Prev")),
    $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Next"))
  );

  $(".card-content").show();
  showPage(1);

  $(document).on("click", ".pagination li.current-page:not(.active1)", function(){
    return showPage(+$(this).text());
  });

  $(".next-page").on("click", function(){
    return showPage(currentPage + 1);
  });

  $(".previous-page").on("click", function(){
    return showPage(currentPage - 1);
  });
});
</script>