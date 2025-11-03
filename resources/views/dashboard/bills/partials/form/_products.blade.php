<x-form.section title="Produits">
  {{-- Ligne produit principale --}}
  <div class="space-y-3" data-line>
    <div class="flex items-center gap-2">
      <div class="grid grid-cols-3 gap-4 flex-1 items-end">
        <x-form.select
          label="Produit"
          name="lines[][product_id]"
          :options="$products->pluck('name', 'id')"
          placeholder="Sélectionner un produit"
          required />

        <x-form.input label="Qté" name="lines[][quantity]" type="number" min="1" required />
        <x-form.input label="Prix unitaire" name="lines[][unit_price]" type="number" step="0.01" required />
      </div>
    </div>

    <div class="mt-3 pl-1" data-options-container></div>
  </div>

  {{-- Lignes dynamiques --}}
  <div id="quote-lines" class="space-y-6 mt-6"></div>

  {{-- Ajouter une ligne --}}
  <x-button type="button" variant="ghost" class="!text-blue-500 hover:!text-blue-700" size="sm"
    onclick="addQuoteLine()">+ Ajouter une ligne</x-button>
</x-form.section>