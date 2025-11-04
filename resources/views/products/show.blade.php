@extends('products.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
        <h2>Show Product</h2>
        <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
    </div>
</div>

<div class="row mt-3">
    <!-- Name -->
    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $product->name }}
        </div>
    </div>

    <!-- Details -->
    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
        <div class="form-group">
            <strong>Details:</strong>
            {{ $product->detail }}
        </div>
    </div>

    <!-- Price -->
    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
        <div class="form-group">
            <strong>Price:</strong>
            ${{ number_format($product->price, 2) }}
        </div>
    </div>

    <!-- Stock -->
    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
        <div class="form-group">
            <strong>Stock:</strong>
            {{ $product->stock }}
        </div>
    </div>

    <!-- Image -->
    @if($product->image)
    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
        <div class="form-group">
            <strong>Image:</strong><br>
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" width="150">
        </div>
    </div>
    @endif
</div>
@endsection
