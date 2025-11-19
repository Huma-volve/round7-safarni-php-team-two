<?php
namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Models\Booking;

class PaymentService
{
    protected $client;

    public function __construct()
    {
        $environment = new SandboxEnvironment(
            config('paypal.client_id'),
            config('paypal.secret')
        );
        $this->client = new PayPalHttpClient($environment);
    }

    public function createPayment(Booking $booking, string $returnUrl, string $cancelUrl)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "Booking_" . $booking->id,
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format(floatval($booking->total_price), 2, '.', '')
                ],
                "description" => "Hotel Booking Payment"
            ]],
            "application_context" => [
                "return_url" => $returnUrl,
                "cancel_url" => $cancelUrl,
                "brand_name" => config('app.name'),
                "landing_page" => "BILLING",
                "user_action" => "PAY_NOW",
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function capturePayment(string $orderId)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
