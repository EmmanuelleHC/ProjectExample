<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function process(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $totalAmount = $request->total * 100; 
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Your Order',
                    ],
                    'unit_amount' => $totalAmount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('transactions.success'),
            'cancel_url' => route('transactions.checkout'),
        ]);

        return response()->json(['id' => $session->id]);
    }
  
}
