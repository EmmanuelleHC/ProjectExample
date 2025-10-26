@extends('layouts.app') {{-- Use your main layout with header + offcanvas menu --}}

@section('title', 'Product Management')

@push('head')
    <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <style>
        .product-container {
            margin-top: 2rem;
        }
    </style>
@endpush

@section('content')
<div class="container product-container">
    <h2 class="mb-4">📦 Product Management</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('product-content')
</div>
@endsection

@push('scripts')
    {{-- EasyUI / jQuery dependencies --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 2500);
        });
    </script>

    @stack('product-scripts')
@endpush
