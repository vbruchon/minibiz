<x-modal id="addOptionModal">
  <div class="space-y-4">
    <h2 class="text-xl font-bold px-6 py-0">Create New Option</h2>

    <x-product-options-form
      context="product"
      :products="$packageProducts"
      :option="null"
      :selected-product-id="$product->id" />
  </div>
</x-modal>