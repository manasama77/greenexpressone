<?php

namespace App\Services;

use Stripe;

class StripeTransaction
{

    public function charge($booking, $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $response = Stripe\Charge::create([
            "amount" => $booking->total_price * 100, // why multiply by 100 ? it's because stripe using the smallest unit in any currency, then it means 1 usd = 100 cent
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Payment of Booking Number #{$booking->booking_number}"
        ]);

        if ($response->status !== 'succeeded') {
            throw new \Exception($response->failure_message, 400);
        }

        return $response;

    }
}
