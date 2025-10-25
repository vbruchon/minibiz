<x-modal id="productOptionModal-{{ $option->id }}">
  <x-product-options-form
    context="product"
    :option="$option"
    :products="$packageProducts"
    :action="route('dashboard.products-options.update', $option->id)"
    method="PUT" />
</x-modal>