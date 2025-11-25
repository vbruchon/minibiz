<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'MiniBiz')</title>

  <script>
    (function() {
      const userPreference = localStorage.getItem('theme');
      const systemPrefDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

      const theme = userPreference ?
        userPreference :
        (systemPrefDark ? 'dark' : 'light');

      document.documentElement.classList.toggle('dark', theme === 'dark');
    })();
  </script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('head')
  @yield('head')
</head>

<body class="bg-background text-foreground antialiased">
  @yield('body')

  @yield('scripts')
  @stack('scripts')
</body>

</html>