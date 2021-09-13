<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PaymongoWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('paymongo.signature')->group(function () {
    Route::post('webhook/paymongo', PaymongoWebhookController::class);
});

$router->group(
    [
        'namespace' => 'Paymongo',
        'as' => 'paymongo.',
    ],
    function () use ($router) {

        $router->post(
            '/source-chargeable',
            'PaymongoCallbackController@sourceChargeable'
        )
            ->middleware('paymongo.signature:source_chargeable')
            ->name('source-chargeable');

        $router->post(
            '/payment-paid',
            'PaymongoCallbackController@paymentPaid'
        )
            ->middleware('paymongo.signature:payment_paid')
            ->name('payment-paid');

        $router->post(
            '/payment-failed',
            'PaymongoCallbackController@paymentFailed'
        )
            ->middleware('paymongo.signature:payment_failed')
            ->name('payment-failed');
    }
);
