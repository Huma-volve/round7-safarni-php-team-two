<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRentalRequest;
use App\Models\CarRental;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;


class CarRentalController extends Controller
{
    public function rentCar(StoreCarRentalRequest $request, $id)
    {
        $validated = $request->validated();
        $carRental = CarRental::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'car_id'  => $id,
        ])
    );
        return response()->json([
            'message' => 'Car rental request received',
            'data' => $carRental
        ], 201);
    }

    public function checkout($carRentalId)
    {
        $carRental = CarRental::find($carRentalId);
        if ($carRental->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $amount = $carRental->total_price;

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'egp',
                    'product_data' => ['name' => 'renting . ' . $carRental->car->brand . ' ' . $carRental->car->model],
                    'unit_amount' => $amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success', ['carRental' => $carRental->id]),
            'cancel_url' => route('stripe.cancel', ['carRental' => $carRental->id]),
            'metadata' => [
                'car_rental_id' => $carRental->id,
            ],
        ]);
        return response()->json(['url' => $session->url,]);
    }
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $carRentalId = $session->metadata->car_rental_id ?? null;

            // ✅ Retrieve PaymentIntent to get payment time
            $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

            // Usually one charge per payment
            $paymentTime = date('Y-m-d H:i:s', $paymentIntent->created);


            if ($carRentalId) {
                $carRental = CarRental::find($carRentalId);

                if ($carRental) {
                    $carRental->update([
                        'status' => 'Confirmed',
                        'payment_status' => 'Paid',
                        'payment_time' => $paymentTime,
                    ]);

                    Log::info('✅ Car Rental payment confirmed: ' . $carRentalId);
                } else {
                    Log::warning('⚠ Car Rental not found: ' . $carRentalId);
                }
            } else {
                Log::warning('⚠ No car_rental_id in session metadata');
            }
        }

        return response('Webhook received', 200);
    }


}
