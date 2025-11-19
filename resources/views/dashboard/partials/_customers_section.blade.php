<div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
    <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-primary/10 border border-gray-700">
        <x-heroicon-o-user-plus class="size-6 text-primary" />
      </div>

      <div>
        <p class="text-gray-400 text-sm">Nouveaux en {{ now()->year }}</p>
        <p class="text-2xl font-bold text-white leading-tight">
          {{ $customerCountYear }}
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-warning/10 border border-gray-700">
        <x-heroicon-o-bolt class="size-6 text-warning" />
      </div>
      <div>
        <p class="text-gray-400 text-sm">Actifs (12 derniers mois)</p>
        <p class="text-2xl font-bold text-white leading-tight">
          {{ $activeCustomerCount }}
        </p>
      </div>
    </div>

  </div>

  <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <div class="border border-gray-700 bg-gray-900/70 rounded-xl p-6 space-y-6">
      <h2 class="text-lg font-semibold text-gray-300">Top Clients par Chiffre d’affaires</h2>

      @forelse ($topCustomers as $row)
      <div class="p-4 border border-gray-700 rounded-lg bg-gray-900/40 hover:bg-gray-900/60 transition flex items-center justify-between">
        <div>
          <p class="text-gray-200 font-medium">{{ $row->customer->company_name }}</p>
          <p class="text-sm text-gray-500">{{ $row->customer->company_email ?? '—' }}</p>
        </div>
        <p class="text-xl font-semibold text-primary">
          {{ number_format($row->total_spent, 2, ',', ' ') }} €
        </p>
      </div>
      @empty
      <p class="text-gray-500 italic">Aucune donnée disponible.</p>
      @endforelse
    </div>

    <div class="border border-gray-700 bg-gray-900/70 rounded-xl p-6 space-y-6">
      <h2 class="text-lg font-semibold text-gray-300">Derniers Clients Ajoutés</h2>

      @forelse ($latestCustomers as $customer)
      <a href="{{ route('dashboard.customers.show', $customer->id) }}"
        class="flex items-center justify-between p-4 border border-gray-700 rounded-lg bg-gray-900/40 hover:bg-gray-900/60 transition group">
        <div>
          <p class="text-gray-200 font-medium">{{ $customer->company_name }}</p>
          <p class="text-sm text-gray-500">Ajouté le {{ $customer->created_at->format('d/m/Y') }}</p>
        </div>
        <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100 text-gray-300" />
      </a>
      @empty
      <p class="text-gray-500 italic">Aucun client enregistré.</p>
      @endforelse
    </div>
  </div>
</div>