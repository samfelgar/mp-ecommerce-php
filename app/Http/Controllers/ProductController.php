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

        $item = $this->createItem($product);

        $mercadoPago = new MercadoPago();
        $preference = $mercadoPago->addItem($item);

        return response()->view('detail', [
            'product' => $product,
            'preference' => $preference->id,
            'publicKey' => config('mercadopago.public_id'),
        ]);
    }

    private function createItem(array $product): Item
    {
        $item = new Item();
        $item->title = $product['title'];
        $item->quantity = $product['unit'];
        $item->unit_price = $product['price'];
        return $item;
    }

    public function pay(Request $request)
    {

    }
}
