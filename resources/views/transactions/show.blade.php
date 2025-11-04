@extends('layouts.app')
@section('title', 'Order Details')
@section('content')
<h2>Transaction #{{ $transaction->invoice_no }}</h2>
<p><strong>Status:</strong> {{ ucfirst($transaction->order_status) }}</p>
<p><strong>Payment:</strong> {{ ucfirst($transaction->payment_status) }}</p>
<p><strong>Total:</strong> ${{ number_format($transaction->total_amount,2) }}</p>

<h4 class="mt-4">Items</h4>
<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transaction->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>${{ number_format($item->price,2) }}</td>
            <td>${{ number_format($item->price * $item->quantity,2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
