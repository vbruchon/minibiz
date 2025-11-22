<x-show-info title="Product Info">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <x-detail-field label="Product Name" :value="$product->name" />
    <x-detail-field label="Type" :value="$product->type === 'time_unit' ? 'Time Unit' : 'Package'" />

    @if($product->unit)
    <x-detail-field label="Unit" :value="$product->unit" />
    @endif

    <x-detail-field label="Base Price (€)" :value="number_format($product->base_price, 2)" />
  </div>
</x-show-info>