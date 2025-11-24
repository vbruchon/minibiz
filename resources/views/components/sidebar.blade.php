<aside class="fixed inset-y-0 left-0 w-56 bg-sidebar text-sidebar-foreground
               border-r border-sidebar-border py-6 px-4 flex flex-col">
  <x-logo />

  <nav class="flex-1">
    <ul class="space-y-2">
      <x-sidebar-item
        href="{{ route('dashboard.index') }}"
        icon="heroicon-s-presentation-chart-line"
        label="Tableau de bord" />

      <x-sidebar-item
        href="{{ route('dashboard.company-settings.index') }}"
        icon="heroicon-s-building-storefront"
        label="Mon Entreprise" />

      <x-sidebar-item
        href="{{ route('dashboard.customers.index') }}"
        icon="heroicon-s-user-group"
        label="Clients" />

      <x-sidebar-item
        href="{{ route('dashboard.products.index') }}"
        icon="heroicon-s-cube"
        label="Produits" />

      <x-sidebar-item
        href="{{ route('dashboard.products-options.index') }}"
        icon="heroicon-o-adjustments-horizontal"
        label="Options produit" />

      <x-sidebar-item
        href="{{ route('dashboard.bills.index') }}"
        icon="heroicon-s-document-currency-euro"
        label="Facturation" />

    </ul>
  </nav>

  <div class="absolute bottom-4 right-4">
    <x-theme-toggle />
  </div>
</aside>