@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    @if($carts->count())
    <form action="{{ route('transactions.processCheckout') }}" method="POST" id="checkout-form">
        @csrf

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carts as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="mt-3">Total: ${{ number_format($total, 2) }}</h4>

        <div class="mb-3">
            <label class="form-label">Shipping Address</label>
            <textarea name="shipping_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="cash">Cash on Delivery</option>
                <option value="stripe">Credit/Debit Card (Stripe Test)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" id="checkout-btn">Confirm Checkout</button>
    </form>

    @else
        <p>Your cart is empty.</p>
    @endif
</div>

{{-- Stripe JS --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkout-form');
    const paymentSelect = document.getElementById('payment_method');
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    form.addEventListener('submit', async function (e) {
        if (paymentSelect.value === 'stripe') {
            e.preventDefault();

            const response = await fetch("{{ route('payment.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    total: {{ $total }},
                })
            });

            const session = await response.json();

            if (session.id) {
                stripe.redirectToCheckout({ sessionId: session.id });
            } else {
                alert("Failed to create payment session.");
            }
        }
    });
});
</script>
@endsection
