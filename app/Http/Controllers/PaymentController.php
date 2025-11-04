<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    /**
     * Create a Stripe Checkout session.
     */
    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('product')->get();
        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Cart Payment (' . $user->name . ')'
                    ],
                    'unit_amount' => $total * 100, 
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        session(['stripe_session_id' => $session->id]);

        return response()->json(['id' => $session->id]);
    }

    /**
     * Handle success redirect.
     */
   
     public function success()
     {
     
         $user = Auth::user();
         if (!$user) {
             return redirect()->route('login');
         }
     
         $carts = Cart::where('user_id', $user->id)->with('product')->get();
         if ($carts->isEmpty()) {
             return redirect()->route('checkout')->with('error', 'Your cart is empty.');
         }
     
         $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);
         $stripeSessionId = session('stripe_session_id');
     
         $transaction = Transaction::create([
             'user_id'          => $user->id,
             'invoice_no'       => 'INV-' . strtoupper(Str::random(8)),
             'total_amount'     => $total,
             'payment_method'   => 'stripe',
             'payment_status'   => 'paid',
             'order_status'     => 'processing',
             'shipping_address' => 'Stripe checkout address',
             'payment_reference'=> $stripeSessionId,
         ]);
     
         foreach ($carts as $item) {
             TransactionItem::create([
                 'transaction_id' => $transaction->id,
                 'product_id'     => $item->product_id,
                 'quantity'       => $item->quantity,
                 'price'          => $item->product->price,
             ]);
         }
     
         Cart::where('user_id', $user->id)->delete();
         session()->forget('stripe_session_id');
     
     
         return redirect()->route('transactions.show', $transaction->id)
             ->with('success', 'Payment successful! Your order has been placed.');
     }
       /**
     * Handle payment cancel.
     */
    public function cancel()
    {
        return redirect()->route('checkout')->with('error', 'Payment canceled.');
    }
}
