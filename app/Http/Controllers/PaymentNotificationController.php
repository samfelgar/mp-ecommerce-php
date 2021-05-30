<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentNotificationController extends Controller
{
    public function feedback(Request $request)
    {
        $data = $request->json();

        if (!empty($data)) {
            Log::info(json_encode($data));
        }

        return response(null, 200);
    }
}
