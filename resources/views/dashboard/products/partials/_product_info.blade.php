<x-show-info title="Info Produit">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <x-detail-field label="Nom du produit :" :value="$product->name" />
    <x-detail-field label="Type :" :value="$product->type === 'time_unit' ? 'Time Unit' : 'Package'" />

    @if($product->unit)
    <x-detail-field label="Unité :" :value="$product->unit" />
    @endif

    <x-detail-field label="Prix de base (€)" :value="number_format($product->base_price, 2)" />
  </div>
</x-show-info>