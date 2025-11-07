<template id="bill-line-template">
  <div class="space-y-3" data-line data-line-index="{lineIndex}">
    <div class="flex items-center gap-2">
      <div class="grid grid-cols-3 gap-4 flex-1 items-end">
        <x-form.select
          label="Produit"
          name="lines[{lineIndex}][product_id]"
          :options="$products->pluck('name', 'id')"
          placeholder="Sélectionner un produit"
          required />

        <x-form.input label="Qté" name="lines[{lineIndex}][quantity]" type="number" min="1" value="1" required />
        <x-form.input label="Prix unitaire" name="lines[{lineIndex}][unit_price]" type="number" step="0.01" required />
      </div>

      <button type="button"
        class="remove-line mt-6 text-destructive hover:text-destructive/70 text-3xl leading-none pb-[2px] hover:!cursor-pointer">
        ×
      </button>
    </div>

    <div class="mt-3 pl-1" data-options-container></div>
  </div>
</template>