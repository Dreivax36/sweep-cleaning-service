<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OrderPaid;
use App\Services\PaypalService;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;

class PayPalController extends Controller
{
    private $paypalService;

    function __construct(PaypalService $paypalService){
        $this->paypalService = $paypalService;
    }

    public function getExpressCheckout(Request $request){
        $response = $this->paypalService->createOrder($request->route('id'));

        if($response->statusCode !== 201){
            abort(500);
        }

        $booking = Booking::find($request->route('id'));
        $booking = Booking::Where('booking_id', $request->route('id'))->update(['paypal_orderid' => $response->result->id]);

        foreach($response->result->links as $link){
            if($link->rel == 'approve'){
                return redirect($link->href);
            }
        }

    }
    public function cancelPage(){
        return redirect()->route('customer.customer_transaction')->withMessage('Payment failed!');
    }

    public function getExpressCheckoutSuccess($booking_id){
        $order = Booking::find($booking_id);
        $response = $this->paypalService->captureOrder($order->paypal_orderid);

        if($response->result->status == 'COMPLETED'){
            //$order->is_paid = 1;
            //$order->save();

           // Mail::to($order->user->email)->send(new OrderPaid($order));
           $updatePayment= Booking::Where('booking_id', $booking_id )->update(['is_paid' => true]);

            return redirect()->route('customer.customer_transaction')->withMessage('Payment successful!');
        }
     
        return redirect()->route('customer.customer_transaction')->withError('Payment Unsuccessful!Something went wrong!');
    }
}
