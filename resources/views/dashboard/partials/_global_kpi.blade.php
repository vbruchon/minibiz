<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
  <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
    <div class="p-3 rounded-full bg-gray-800 border border-gray-700">
      <x-heroicon-o-users class="size-6 text-gray-200" />
    </div>
    <div>
      <p class="text-gray-400 text-sm">Total clients</p>
      <p class="text-2xl font-bold text-white leading-tight">
        {{ $customerCount }}
      </p>
    </div>
  </div>

  <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
    <div class="p-3 rounded-full bg-gray-800 border border-gray-700">
      <x-heroicon-o-document-text class="size-6 text-gray-200" />
    </div>
    <div>
      <p class="text-gray-400 text-sm">Total devis</p>
      <p class="text-2xl font-bold text-white leading-tight">
        {{ $quotesCount }}
      </p>
    </div>
  </div>

  <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
    <div class="p-2.5 rounded-full bg-primary/8 border border-gray-700">
      <x-heroicon-o-document-check class="size-6 text-primary" />
    </div>
    <div>
      <p class="text-gray-400 text-sm">Total factures</p>
      <p class="text-2xl font-bold text-white leading-tight">
        {{ $invoicesCount }}
      </p>
    </div>
  </div>

  <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
    <div class="p-3 rounded-full bg-warning/10 border border-gray-700">
      <x-heroicon-o-currency-euro class="size-6 text-warning" />
    </div>
    <div>
      <p class="text-gray-400 text-sm">Revenus {{ now()->year }}</p>
      <p class="text-2xl font-bold text-white leading-tight">
        {{ number_format($yearRevenue, 2, ',', ' ') }} €
      </p>
    </div>
  </div>

</div>