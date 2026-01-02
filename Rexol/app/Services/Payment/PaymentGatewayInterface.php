<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    /**
     * Charge the user.
     *
     * @param float $amount
     * @param array $details (e.g., token, currency, description)
     * @return mixed Response from gateway
     * @throws \Exception
     */
    public function charge(float $amount, array $details);
}
