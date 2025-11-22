<x-modal id="addOptionModal">
  <div class="p-6 space-y-6 text-foreground">
    <h2 class="text-xl font-bold">Create New Option</h2>

    <x-product-options-form
      context="product"
      :products="$packageProducts"
      :option="null"
      :selected-product-id="$product->id" />
  </div>
</x-modal>