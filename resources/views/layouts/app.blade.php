<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My App')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <style>
      body { overflow-x: hidden; }
      .offcanvas-end { width: 260px; }
      .navbar-brand img { max-height: 50px; }
    </style>
  </head>
<body>

  <!-- Header -->
  <header class="border-bottom py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="/" class="text-dark text-decoration-none navbar-brand">
        <img src="{{ asset('images/logo_toko.jpg') }}" alt="Toko Kelontong">
      </a>

      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
          ☰ Menu
        </button>
        <a class="btn btn-danger" href="{{ route('logout') }}">
            Logout
        </a>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container mb-4">
      @yield('content')
  </div>

  <!-- Sidebar (Offcanvas Menu) -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
    <div class="offcanvas-header">
      <h5 id="menuOffcanvasLabel">Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <a href="{{ route('dashboard') }}" class="text-decoration-none">🏠 Dashboard</a>
        </li>
        <li class="list-group-item">
          <a href="{{ route('products.index') }}" class="text-decoration-none">📦 Products</a>
        </li>
        <li class="list-group-item">
          <a href="{{ route('cart.index') }}" class="text-decoration-none">🛒 Cart</a>
        </li>
        <li class="list-group-item">
          <a href="{{ route('transactions.index') }}" class="text-decoration-none">🧾 Orders</a>
        </li>
        <li class="list-group-item">
          <a href="#" class="text-decoration-none">👤 Profile</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
