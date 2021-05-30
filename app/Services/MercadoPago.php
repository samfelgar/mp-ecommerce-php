<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use MercadoPago\Item;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPago {

    public Payment $payment;
    public Preference $preference;

    public function __construct()
    {
        SDK::setAccessToken(config('mercadopago.token'));
        $this->payment = new Payment();
        $this->preference = new Preference();
    }

    public function addItem(Item $item): Preference
    {
        $this->preference->items[] = $item;
        $this->preference->save();
        return $this->preference;
    }

    public function pay(array $order): Payment
    {
        if (!$this->validateOrder($order)) {
            throw new \InvalidArgumentException('Error while validating the order');
        }

        $this->payment->transaction_amount = $order['transaction_amount'];
        $this->payment->token = $order['token'];
        $this->payment->description = $order['description'];
        $this->payment->installments = $order['installments'];
        $this->payment->payment_method_id = $order['payment_method_id'];
        $this->payment->payer = $order['payer'];

        $this->payment->save();

        return $this->payment;
    }

    protected function validateOrder(array $order): bool
    {
        try {
            $this->assertRequiredFields($order);

            if ($order['installments'] > 6) {
                return false;
            }

            if ($order['payment_method_id'] === 'amex') {
                return false;
            }

            return true;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    protected function assertRequiredFields(array $order)
    {
        $required = [
            'transaction_amount',
            'token',
            'description',
            'installments',
            'payment_method_id',
            'payer'
        ];

        $missing = array_diff_key(array_flip($required), $order);

        if (!$missing) {
            throw new \InvalidArgumentException('Required fields not provided: ' . implode(', ', $missing));
        }
    }
}
