<div class="flex items-center justify-between">
  <h1 class="text-3xl font-bold text-foreground">Tableau de bord</h1>

  <div class="flex items-center gap-3">

    {{-- Créer un devis (action principale) --}}
    <x-button
      :href="route('dashboard.bills.create', ['type' => 'quote'])"
      variant="primary"
      size="sm"
      class="flex items-center gap-2">
      <x-heroicon-o-plus class="size-4" />
      Créer un devis
    </x-button>

    {{-- Créer une facture (action importante mais secondaire) --}}
    <x-button
      :href="route('dashboard.bills.create', ['type' => 'invoice'])"
      variant="warning"
      size="sm"
      class="flex items-center gap-2">
      <x-heroicon-o-plus class="size-4" />
      Créer une facture
    </x-button>

    {{-- Ajouter un client (neutre positif / bleu = info) --}}
    <x-button
      :href="route('dashboard.customers.create')"
      variant="info"
      size="sm"
      class="flex items-center gap-2">
      <x-heroicon-o-plus class="size-4" />
      Ajouter un client
    </x-button>

    {{-- Ajouter un produit (action tertiaire → outline) --}}
    <x-button
      :href="route('dashboard.products.create')"
      variant="outline"
      size="sm"
      class="flex items-center gap-2">
      <x-heroicon-o-plus class="size-4" />
      Ajouter un produit
    </x-button>

  </div>
</div>