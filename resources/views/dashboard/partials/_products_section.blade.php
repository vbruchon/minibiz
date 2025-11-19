<div>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
    <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-gray-800 border border-gray-700">
        <x-heroicon-o-cube class="size-6 text-gray-200" />
      </div>

      <div>
        <p class="text-gray-400 text-sm">Total produits</p>
        <p class="text-3xl font-bold text-white leading-tight">
          {{ $productCount }}
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-primary/10 border border-gray-700">
        <x-heroicon-o-chart-bar class="size-6 text-primary" />
      </div>
      <div>
        <p class="text-gray-400 text-sm">Produit le plus vendu</p>
        <p class="text-xl font-semibold text-white leading-tight mt-1">
          {{ $bestProduct ? $bestProduct->product->name : '—' }}
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-6 border border-gray-700 bg-gray-900/70 rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-warning/10 border border-gray-700">
        <x-heroicon-o-exclamation-circle class="size-6 text-warning" />
      </div>
      <div>
        <p class="text-gray-400 text-sm">Produits jamais vendus</p>
        <p class="text-3xl font-bold text-white leading-tight">
          {{ $unusedProducts }}
        </p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <div class="border border-gray-700 bg-gray-900/70 rounded-xl p-6 space-y-6">
      <h2 class="text-lg font-semibold text-gray-300 flex items-center gap-6">Top Produits les Plus Vendus
        <x-heroicon-o-chart-bar class="size-5 text-primary" />

      </h2>
      <div class="grid grid-cols-2 gap-4">
        @forelse ($topProducts as $row)
        <div class="p-4 border border-gray-700 rounded-lg bg-gray-900/40 hover:bg-gray-900/60 transition flex items-center justify-between">
          <div>
            <p class="text-gray-200 font-medium">{{ $row->product->name }}</p>
            <p class="text-sm text-gray-500">Total vendus : {{ $row->total_sold }}</p>
          </div>
        </div>
        @empty
        <p class="text-gray-500 italic">Aucun produit vendu pour le moment.</p>
        @endforelse
      </div>
    </div>

    <div class="border border-gray-700 bg-gray-900/70 rounded-xl p-6 space-y-8">
      <div class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-300">Top Options Produits</h2>

        @if ($topOptions->isNotEmpty())
        @foreach($topOptions as $topOption)
        <div class="flex items-center justify-between p-4 border border-gray-700 rounded-lg bg-gray-900/40">
          <div>
            <p class="text-gray-200 font-medium">
              {{ $topOption->productOptionValue->option->name }}
            </p>
            <p class="text-sm text-gray-500">
              Valeur : {{ $topOption->productOptionValue->value }}
            </p>
          </div>
          <p class="text-xl font-semibold text-primary">
            {{ $topOption->total }}×
          </p>
        </div>
        @endforeach
        @else
        <p class="text-gray-500 italic">Aucune option sélectionnée.</p>
        @endif
      </div>
    </div>
  </div>
</div>