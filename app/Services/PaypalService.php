<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Price;
use App\Models\Service;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaypalService
{
    private $client;

    function __construct()
    {
        $environment = new SandboxEnvironment(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'));
        $this->client = new PayPalHttpClient($environment);
    }

    public function createOrder($orderId)
    {

        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = $this->checkoutData($orderId);
        //$request->body = $this->simpleCheckoutData($orderId);

        return $this->client->execute($request);
    }

    public function captureOrder($paypalOrderId)
    {
        $request = new OrdersCaptureRequest($paypalOrderId);

        return $this->client->execute($request);
    }

    private function simpleCheckoutData($booking_id)
    {
        $booking = Booking::find($booking_id);
        $amount = Price::where('service_id', $booking->service_id)->where('property_type', $booking->property_type)->value('price');

        return [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => 'sweep_'. uniqid(),
                "amount" => [
                    "value" => $amount,
                    "currency_code" => "PHP"
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success', $booking_id)
            ]
            ];
    }


    private function checkoutData($booking_id)
    {
        $booking = Booking::find($booking_id);
        $orderItems = [];
        $amount = Price::where('service_id', $booking->service_id)->where('property_type', $booking->property_type)->value('price');
        $service = Service::find($booking->service_id);
            $orderItems[] = [
                'name' => $service->service_name,
                'description' => \Str::limit($service->service_description, 100),
                'quantity' => 0,
                'unit_amount' => [
                    'currency_code' => 'PHP',
                    'value' => $amount,
                ],
                'category' => 'PHYSICAL_GOODS',
            ];
    
        



        $checkoutData = [
            'intent' => 'CAPTURE',
            'application_context' =>
            [
                'return_url' => route('paypal.success', $booking_id),
                'cancel_url' => route('paypal.cancel'),
                'brand_name' => 'Sweep',
                'locale' => 'en-PH',
                'landing_page' => 'BILLING',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'reference_id' =>  uniqid(),
                    'description' => 'some order description for the order',
                    'custom_id' => 'CUST-HighFashions',
                    'soft_descriptor' => 'HighFashions',
                    'shipping' =>
                    [
                        'method' => 'United States Postal Service',
                        'name' =>
                        [
                            'full_name' => 'John Doe',
                        ],
                        'address' =>
                        [
                            'address_line_1' => '123 Townsend St',
                            'address_line_2' => 'Floor 6',
                            'admin_area_2' => 'San Francisco',
                            'admin_area_1' => 'CA',
                            'postal_code' => '94107',
                            'country_code' => 'US',
                        ],
                    ],
                    'amount' =>
                    [
                        'currency_code' => 'PHP',
                        'value' => 1,
                        'breakdown' =>
                        [
                            'item_total' =>
                            [
                                'currency_code' => 'PHP',
                                'value' => 1,
                            ],
                            'shipping' =>
                            [
                                'currency_code' => 'PHP',
                                'value' => '0',
                            ],
                            'handling' =>
                            [
                                'currency_code' => 'PHP',
                                'value' => '0',
                            ],
                            'tax_total' =>
                            [
                                'currency_code' => 'PHP',
                                'value' => '0',
                            ],
                            'shipping_discount' =>
                            [
                                'currency_code' => 'PHP',
                                'value' => '0',
                            ],
                        ],
                    ],
                ]
            ],

        ];

        return $checkoutData;
    }
}