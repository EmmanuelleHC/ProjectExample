@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <!-- Success message -->
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
  @endif

  <!-- Welcome Section -->
  <div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
      <p class="col-md-8 fs-4">
        Welcome to your dashboard.<br>
        Use the menu on the right to navigate.
      </p>
    </div>
  </div>

  <!-- Product Grid -->
  <h2 class="mb-4">Available Products</h2>
  <div class="row">
    @foreach($products as $product)
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
          @endif
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">${{ number_format($product->price, 2) }}</p>
            <p class="card-text">Stock: {{ $product->stock }}</p>

            <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control mb-2">
              <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
