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

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control" placeholder="Enter product name">
        </div>

        <div class="col-md-12 mb-3">
            <label for="detail" class="form-label"><strong>Detail:</strong></label>
            <textarea name="detail" id="detail" class="form-control" style="height:150px" placeholder="Enter product detail">{{ old('detail', $product->detail) }}</textarea>
        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </div>
</form>
@endsection
