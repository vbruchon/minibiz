<div>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
    <x-kpi-card
      icon="heroicon-o-cube"
      icon-bg="bg-muted/20"
      icon-color="text-muted-foreground"
      label="Total produits"
      value="{{ $productCount }}" />

    <x-kpi-card
      icon="heroicon-o-chart-bar"
      icon-bg="bg-primary/10"
      icon-color="text-primary"
      label="Produit le plus vendu"
      value="{{ $bestProduct ? $bestProduct->product->name : '—' }}"
      value-size="text-xl" />

    <x-kpi-card
      icon="heroicon-o-exclamation-circle"
      icon-bg="bg-warning/10"
      icon-color="text-warning"
      label="Produits jamais vendus"
      value="{{ $unusedProducts }}" />
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <x-card title="Top Produits les Plus Vendus">
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
    </x-card>

    <x-card title="Top Options Produits">
      <div class="space-y-4">
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
    </x-card>
  </div>
</div>