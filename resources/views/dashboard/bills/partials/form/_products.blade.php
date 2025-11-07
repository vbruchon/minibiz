<x-form.section title="Produits">
  <div id="quote-lines" class="space-y-4">
    <div class="space-y-3" data-line data-line-index="0">
      <div class="flex items-center gap-2">
        <div class="grid grid-cols-3 gap-4 flex-1 items-end">
          <x-form.select
            label="Produit"
            name="lines[0][product_id]"
            :options="$products->pluck('name', 'id')"
            placeholder="Sélectionner un produit"
            :selected="old('lines.0.product_id', $bill->lines[0]->product_id ?? null)"
            required />

          <x-form.input
            label="Qté"
            name="lines[0][quantity]"
            type="number"
            min="1"
            :value="old('lines.0.quantity', $bill->lines[0]->quantity ?? 1)"
            required />

          <x-form.input
            label="Prix unitaire"
            name="lines[0][unit_price]"
            type="number"
            step="0.01"
            :value="old('lines.0.unit_price', $bill->lines[0]->unit_price ?? null)"
            required />
        </div>

        <button type="button"
          class="remove-line mt-6 text-destructive hover:text-destructive/70 text-3xl leading-none pb-[2px]">
          ×
        </button>
      </div>

      <div class="mt-3 pl-1" data-options-container></div>
    </div>
  </div>

  <x-button id="addProduct" variant="ghost" size="sm" class="mt-4">
    + Ajouter un produit
  </x-button>
</x-form.section>