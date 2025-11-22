<div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">

    <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-primary/10 border border-border">
        <x-heroicon-o-user-plus class="size-6 text-primary" />
      </div>

      <div>
        <p class="text-sm text-muted-foreground">Nouveaux en {{ now()->year }}</p>
        <p class="text-2xl font-bold text-foreground leading-tight">
          {{ $customerCountYear }}
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-warning/10 border border-border">
        <x-heroicon-o-bolt class="size-6 text-warning" />
      </div>

      <div>
        <p class="text-sm text-muted-foreground">Actifs (12 derniers mois)</p>
        <p class="text-2xl font-bold text-foreground leading-tight">
          {{ $activeCustomerCount }}
        </p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <div class="bg-card border border-border rounded-xl p-6 space-y-6">
      <h2 class="text-lg font-semibold text-foreground">Top Clients par Chiffre d’affaires</h2>

      @forelse ($topCustomers as $row)
      <div class="p-4 border border-border bg-muted/10 rounded-lg flex items-center justify-between">
        <div>
          <p class="text-foreground font-medium">
            {{ $row->customer->company_name }}
          </p>
          <p class="text-sm text-muted-foreground">
            {{ $row->customer->company_email ?? '—' }}
          </p>
        </div>
        <p class="text-xl font-semibold text-primary">
          {{ number_format($row->total_spent, 2, ',', ' ') }} €
        </p>
      </div>
      @empty
      <p class="text-muted-foreground italic">Aucune donnée disponible.</p>
      @endforelse
    </div>

    <div class="bg-card border border-border rounded-xl p-6 space-y-6">
      <h2 class="text-lg font-semibold text-foreground">Derniers Clients Ajoutés</h2>

      @forelse ($latestCustomers as $customer)
      <a href="{{ route('dashboard.customers.show', $customer->id) }}"
        class="flex items-center justify-between p-4 border border-border bg-muted/10 rounded-lg transition group">
        <div>
          <p class="text-foreground font-medium">
            {{ $customer->company_name }}
          </p>
          <p class="text-sm text-muted-foreground">
            Ajouté le {{ $customer->created_at->format('d/m/Y') }}
          </p>
        </div>
        <x-heroicon-o-eye class="size-5 text-muted-foreground opacity-0 transition group-hover:opacity-100" />
      </a>
      @empty
      <p class="text-muted-foreground italic">Aucun client enregistré.</p>
      @endforelse
    </div>
  </div>
</div>