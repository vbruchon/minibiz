<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MiniBiz Dashboard')</title>

  {{-- Anti-flash theme --}}
  <script>
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
      document.documentElement.classList.add('dark');
    }
  </script>

  @vite('resources/css/app.css')
  @yield('head')
  @stack('styles')
</head>

<body class="font-sans bg-background text-foreground antialiased">

  <!-- Sidebar -->
  <aside
    class="fixed inset-y-0 left-0 w-56 bg-sidebar text-sidebar-foreground
           border-r border-sidebar-border py-6 px-4 flex flex-col">

    <!-- Logo -->
    <a href="/" class="flex items-center gap-2 mb-12 ml-2">
      <img src="/logo.png" alt="MiniBiz Logo" class="size-12">
      <span class="text-2xl font-bold">MiniBiz</span>
    </a>

    <!-- Navigation -->
    <nav class="flex-1">
      <ul class="space-y-1">

        <li>
          <a href="{{ route('dashboard.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg 
                    hover:bg-sidebar-accent transition-colors">
            <x-heroicon-s-presentation-chart-line class="size-5" />
            <span>Tableau de bord</span>
          </a>
        </li>

        <li>
          <a href="{{ route('dashboard.company-settings.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg 
                    hover:bg-sidebar-accent transition-colors">
            <x-heroicon-s-building-storefront class="size-5" />
            <span>Mon Entreprise</span>
          </a>
        </li>

        <li>
          <a href="{{ route('dashboard.customers.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg 
                    hover:bg-sidebar-accent transition-colors">
            <x-heroicon-s-user-group class="size-5" />
            <span>Clients</span>
          </a>
        </li>

        <li>
          <a href="{{ route('dashboard.products.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg 
                    hover:bg-sidebar-accent transition-colors">
            <x-heroicon-s-cube class="size-5" />
            <span>Produits</span>
          </a>
        </li>

        <li>
          <a href="{{ route('dashboard.products-options.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg 
                    hover:bg-sidebar-accent transition-colors">
            <x-heroicon-o-adjustments-horizontal class="size-5" />
            <span>Options produit</span>
          </a>
        </li>

        <li>
          <a href="{{ route('dashboard.bills.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg 
                    hover:bg-sidebar-accent transition-colors">
            <x-heroicon-s-document-currency-euro class="size-5" />
            <span>Facturation</span>
          </a>
        </li>

      </ul>
    </nav>

    <!-- Theme toggle -->
    <div class="absolute bottom-4 right-4">
      <x-theme-toggle />

    </div>
  </aside>

  <main class="ml-56 p-8">
    @yield('content')
  </main>

  @yield('scripts')
  @stack('scripts')

  {{-- Toasters --}}
  @if(session('success'))
  <x-toast type="success" :message="session('success')" />
  @endif

  @if(session('error'))
  <x-toast type="error" :message="session('error')" />
  @endif

  <!-- Theme Toggle Script -->
  <script>
    const html = document.documentElement;
    const btn = document.getElementById('theme-toggle');
    const sun = document.getElementById('icon-sun');
    const moon = document.getElementById('icon-moon');

    function updateIcons() {
      const isDark = html.classList.contains('dark');
      moon.classList.toggle('hidden', !isDark);
      sun.classList.toggle('hidden', isDark);
    }

    updateIcons();

    btn.addEventListener('click', () => {
      html.classList.toggle('dark');
      localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
      updateIcons();
    });
  </script>
</body>

</html>