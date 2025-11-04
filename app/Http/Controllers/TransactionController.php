<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('items.product');

        return view('transactions.show', compact('transaction'));
    }

    public function checkout()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $carts->sum(fn($item) => $item->product->price * $item->quantity);

        return view('transactions.checkout', compact('carts', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->with('product')->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id'         => $userId,
                'invoice_no'      => 'INV-' . strtoupper(Str::random(8)),
                'total_amount'    => $carts->sum(fn($item) => $item->product->price * $item->quantity),
                'payment_method'  => $request->payment_method ?? 'cash',
                'payment_status'  => 'pending',
                'order_status'    => 'processing',
                'shipping_address'=> $request->shipping_address ?? 'N/A',
            ]);

            foreach ($carts as $cart) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $cart->product_id,
                    'quantity'       => $cart->quantity,
                    'price'          => $cart->product->price,
                ]);
            }

            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Checkout complete. Awaiting payment.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
