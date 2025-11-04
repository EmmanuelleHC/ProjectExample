@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<h2>My Orders</h2>
@if($transactions->count())
<table class="table">
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Total</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->invoice_no }}</td>
            <td>${{ number_format($transaction->total_amount,2) }}</td>
            <td>{{ ucfirst($transaction->order_status) }}</td>
            <td>{{ ucfirst($transaction->payment_status) }}</td>
            <td>
                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">View</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $transactions->links() }}
@else
<p>No orders yet.</p>
@endif
@endsection
