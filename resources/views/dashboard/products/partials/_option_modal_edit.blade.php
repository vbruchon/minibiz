<x-modal id="productOptionModal-{{ $option->id }}">
  <div class="p-6 space-y-6 text-foreground">
    <x-product-options-form
      context="product"
      :option="$option"
      :products="$packageProducts"
      :action="route('dashboard.products-options.update', $option->id)"
      method="PUT" />
  </div>
</x-modal>