@extends('layouts.app')
@section('title', 'Cart')
@section('content')
<h2>Your Cart</h2>
@if($carts->count())
<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($carts as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:70px;">
                    <button class="btn btn-sm btn-primary">Update</button>
                </form>
            </td>
            <td>${{ number_format($item->product->price,2) }}</td>
            <td>${{ number_format($item->product->price * $item->quantity,2) }}</td>
            <td>
                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Remove</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-3">
    <h4>Total: ${{ number_format($total,2) }}</h4>
    <a href="{{ route('transactions.checkout') }}" class="btn btn-success">Proceed to Checkout</a>
</div>
@else
<p>Your cart is empty.</p>
@endif
@endsection
