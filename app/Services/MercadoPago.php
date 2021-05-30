<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPago
{
    public function __construct()
    {
        SDK::setAccessToken(config('mercadopago.token'));
        SDK::setIntegratorId(config('mercadopago.integrator_id'));
    }

    public function createItem(array $product): Item
    {
        $item = new Item();
        $item->id = 1234;
        $item->title = $product['title'];
        $item->description = 'Celular de Tienda e-commerce';
        $item->quantity = $product['unit'];
        $item->unit_price = $product['price'];
        $item->picture_url = $product['img'];
        return $item;
    }

    public function createPreference(): Preference
    {
        $preference = new Preference();
        $preference->back_urls = [
            'success' => route('result'),
            'pending' => route('result'),
            'failure' => route('result'),
        ];
        $preference->notification_url = route('notifications.feedback');
        $preference->payment_methods = [
            'excluded_payment_methods' => [
                ['id' => 'amex']
            ],
            'installments' => 6,
        ];
        $preference->external_reference = 'samfelgar@gmail.com';

        return $preference;
    }

    public function createPayer(): Payer
    {
        $payer = new Payer();
        $payer->name = 'Lalo';
        $payer->surname = 'Landa';
        $payer->email = 'test_user_92801501@testuser.com';
        $payer->phone = [
            'area_code' => '55',
            'number' => '98529-8743',
        ];
        $payer->address = [
            'zip_code' => '78134-190',
            'street_name' => 'Insurgentes Sur',
            'street_number' => '1602',
        ];

        return $payer;
    }

    public function addItemToPreference(Preference $preference, Item $item): Preference
    {
        $preference->items = [$item];
        return $preference;
    }

    public function addPayerToPreference(Preference $preference, Payer $payer): Preference
    {
        $preference->payer = $payer;
        return $preference;
    }

    public function savePreference(Preference $preference): bool
    {
        return $preference->save();
    }

    public function pay(array $order): Payment
    {
        if (!$this->validateOrder($order)) {
            throw new \InvalidArgumentException('Error while validating the order');
        }

        $payment = new Payment();

        $payment->transaction_amount = $order['transaction_amount'];
        $payment->token = $order['token'];
        $payment->description = $order['description'];
        $payment->installments = $order['installments'];
        $payment->payment_method_id = $order['payment_method_id'];
        $payment->payer = $order['payer'];

        $payment->save();

        return $payment;
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
