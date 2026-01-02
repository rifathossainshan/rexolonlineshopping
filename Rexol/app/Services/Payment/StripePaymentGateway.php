<?php

namespace App\Services\Payment;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge(float $amount, array $details)
    {
        try {
            // Stripe expects amount in cents for USD, etc.
            // Assuming default currency is USD or equivalent where 100 cents = 1 unit.
            // Adjust currency as needed from config or details.
            $currency = $details['currency'] ?? 'usd';

            $charge = Charge::create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => $currency,
                'source' => $details['source'], // Token from Stripe.js
                'description' => $details['description'] ?? 'Order Payment',
                'metadata' => $details['metadata'] ?? [],
            ]);

            return $charge;

        } catch (CardException $e) {
            // Card was declined
            throw new \Exception("Payment failed: " . $e->getMessage());
        } catch (\Exception $e) {
            // Generic error
            throw new \Exception("Payment error: " . $e->getMessage());
        }
    }
}
