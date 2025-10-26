@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
  @endif

  <div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
      <p class="col-md-8 fs-4">
        Welcome to your dashboard.<br>
        Use the menu on the right to navigate.
      </p>
    </div>
  </div>
@endsection
