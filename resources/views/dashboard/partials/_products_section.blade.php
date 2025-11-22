<div>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
    <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-muted/20 border border-border">
        <x-heroicon-o-cube class="size-6 text-muted-foreground" />
      </div>

      <div>
        <p class="text-sm text-muted-foreground">Total produits</p>
        <p class="text-3xl font-bold text-foreground leading-tight">
          {{ $productCount }}
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-primary/10 border border-border">
        <x-heroicon-o-chart-bar class="size-6 text-primary" />
      </div>

      <div>
        <p class="text-sm text-muted-foreground">Produit le plus vendu</p>
        <p class="text-xl font-semibold text-foreground leading-tight mt-1">
          {{ $bestProduct ? $bestProduct->product->name : '—' }}
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
      <div class="p-3 rounded-full bg-warning/10 border border-border">
        <x-heroicon-o-exclamation-circle class="size-6 text-warning" />
      </div>

      <div>
        <p class="text-sm text-muted-foreground">Produits jamais vendus</p>
        <p class="text-3xl font-bold text-foreground leading-tight">
          {{ $unusedProducts }}
        </p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <div class="bg-card border border-border rounded-xl p-6 space-y-6">
      <h2 class="text-lg font-semibold text-foreground flex items-center gap-6">
        Top Produits les Plus Vendus
        <x-heroicon-o-chart-bar class="size-5 text-primary" />
      </h2>

      <div class="grid grid-cols-2 gap-4">
        @forelse ($topProducts as $row)
        <div class="p-4 border border-border bg-muted/10 rounded-lg transition flex items-center justify-between">
          <div>
            <p class="text-foreground font-medium">{{ $row->product->name }}</p>
            <p class="text-sm text-muted-foreground">
              Total vendus : {{ $row->total_sold }}
            </p>
          </div>
        </div>
        @empty
        <p class="text-muted-foreground italic">Aucun produit vendu pour le moment.</p>
        @endforelse
      </div>
    </div>

    <div class="bg-card border border-border rounded-xl p-6 space-y-8">
      <div class="space-y-4">
        <h2 class="text-lg font-semibold text-foreground">Top Options Produits</h2>
        @if ($topOptions->isNotEmpty())
        @foreach($topOptions as $topOption)
        <div class="flex items-center justify-between bg-muted/10 p-4 border border-border rounded-lg">
          <div>
            <p class="text-foreground font-medium">
              {{ $topOption->productOptionValue->option->name }}
            </p>
            <p class="text-sm text-muted-foreground">
              Valeur : {{ $topOption->productOptionValue->value }}
            </p>
          </div>

          <p class="text-xl font-semibold text-primary">
            {{ $topOption->total }}×
          </p>
        </div>
        @endforeach
        @else
        <p class="text-muted-foreground italic">Aucune option sélectionnée.</p>
        @endif
      </div>
    </div>
  </div>
</div>