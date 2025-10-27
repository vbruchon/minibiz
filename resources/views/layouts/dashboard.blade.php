<!DOCTYPE html>
<html lang="en" class="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MiniBiz Dashboard')</title>
  @vite('resources/css/app.css')


  @stack('styles')

</head>

<body class="font-sans bg-gray-800 text-white">

  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 h-full w-56 bg-gray-900 text-foreground border-r border-gray-700 py-6 px-4">
    <div class="flex items-center gap-2 mb-12 ml-2">
      <img src="/logo.png" alt="MiniBiz Logo" class="size-12">
      <span class="text-2xl font-bold">MiniBiz</span>
    </div>
    <nav>
      <ul class="space-y-2 list-none">
        <li>
          <a href="{{ route('dashboard.company-settings.index') }}"
            class="flex gap-2 items-center p-3 rounded hover:bg-gray-700">
            <x-heroicon-s-building-storefront class="size-6" />
            Mon Entreprise
          </a>
        </li>
        <li>
          <a href="{{ route('dashboard.customers.index') }}"
            class="flex gap-2 items-center p-3 rounded hover:bg-gray-700">
            <x-heroicon-s-user-group class="size-6" />
            Customers
          </a>
        </li>
        <li>
          <a href="{{ route('dashboard.products.index') }}"
            class="flex gap-2 items-center p-3 rounded hover:bg-gray-700">
            <x-heroicon-s-cube class="size-6" />
            Products
          </a>
        </li>
        <li>
          <a href="{{ route('dashboard.products-options.index') }}"
            class="flex gap-2 items-center p-3 rounded hover:bg-gray-700">
            <x-heroicon-o-adjustments-horizontal class="size-6" />
            Products Options
          </a>
        </li>
        <li>
          <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Orders</a>
        </li>
      </ul>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="ml-56 p-8">
    @yield('content')
  </main>
  @yield('scripts')
  @stack('scripts')
  @if(session('success'))
  <x-toast type="success" :message="session('success')" />
  @endif

  @if(session('error'))
  <x-toast type="error" :message="session('error')" />
  @endif
</body>

</html>