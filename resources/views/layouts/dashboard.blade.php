<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MiniBiz Dashboard')</title>

  <script>
    const savedTheme = localStorage.getItem('theme') ?? 'light';
    if (savedTheme === 'dark') document.documentElement.classList.add('dark');
  </script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('styles')
  @yield('head')
</head>

<body class="font-sans bg-background text-foreground antialiased">

  <x-sidebar />

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