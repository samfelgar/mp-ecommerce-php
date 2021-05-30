<?php

namespace App\Http\Controllers;

use App\Services\MercadoPago;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MercadoPago\Item;

class ProductController extends Controller
{
    public function detail(Request $request): Response
    {
        $product = $request->only([
            'title',
            'price',
            'unit',
            'img'
        ]);

        $mercadoPago = new MercadoPago();

        $preference = $mercadoPago->createPreference();

        $item = $mercadoPago->createItem($product);

        $mercadoPago->addItemToPreference($preference, $item);

        $mercadoPago->addPayerToPreference($preference, $mercadoPago->createPayer());

        $mercadoPago->savePreference($preference);

        return response()->view('detail', [
            'product' => $product,
            'preference' => $preference->id,
            'publicKey' => config('mercadopago.public_id'),
        ]);
    }
}
