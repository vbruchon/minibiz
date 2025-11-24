  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
    <x-kpi-card
      icon="heroicon-o-user-plus"
      label="Nouveaux en {{ now()->year }}"
      :value="$customerCountYear"
      iconBg="bg-primary/10"
      iconColor="text-primary" />

    <x-kpi-card
      icon="heroicon-o-bolt"
      label="Actifs (12 derniers mois)"
      :value="$activeCustomerCount"
      iconBg="bg-warning/10"
      iconColor="text-warning" />

    <x-card title="Top Clients par Chiffre d’affaires">
      @forelse ($topCustomers as $row)
      <div class="p-4 border border-border bg-muted/10 rounded-lg flex items-center justify-between">
        <div class="flex flex-col gap-1">
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
    </x-card>

    <x-card title="Derniers Clients Ajoutés">
      @forelse ($latestCustomers as $customer)
      <a href="{{ route('dashboard.customers.show', $customer->id) }}"
        class="flex items-center justify-between p-4 border border-border bg-muted/10 rounded-lg transition group">
        <div class="flex flex-col gap-1">
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
    </x-card>
  </div>