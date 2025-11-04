@extends('products.layout')

@section('content')
<div class="row mb-3">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2>Edit Product</h2>
        <a class="btn btn-secondary" href="{{ route('products.index') }}">Back</a>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input:<br><br>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Name -->
        <div class="col-md-12 mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control" placeholder="Enter product name" required>
        </div>

        <!-- Detail -->
        <div class="col-md-12 mb-3">
            <label for="detail" class="form-label"><strong>Detail:</strong></label>
            <textarea name="detail" id="detail" class="form-control" style="height:150px" placeholder="Enter product detail" required>{{ old('detail', $product->detail) }}</textarea>
        </div>

        <!-- Price -->
        <div class="col-md-12 mb-3">
            <label for="price" class="form-label"><strong>Price:</strong></label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="form-control" step="0.01" placeholder="Enter product price" required>
        </div>

        <!-- Stock -->
        <div class="col-md-12 mb-3">
            <label for="stock" class="form-label"><strong>Stock:</strong></label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="form-control" placeholder="Enter product stock" required>
        </div>

        <!-- Image -->
        <div class="col-md-12 mb-3">
            <label for="image" class="form-label"><strong>Image:</strong></label>
            <input type="file" name="image" id="image" class="form-control">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" width="100" class="mt-2">
            @endif
        </div>

        <div class="col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </div>
</form>
@endsection
