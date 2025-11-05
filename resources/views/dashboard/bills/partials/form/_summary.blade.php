<x-form.section title="Résumé du devis">
  <div class="p-4 border border-gray-700 rounded-lg bg-gray-800/50 text-right space-y-1">
    <p class="text-sm text-gray-400">Sous-total :
      <span id="subtotal" class="text-white font-semibold">0.00 €</span>
    </p>
    <p class="text-sm text-gray-400">
      Remise globale :
      <span id="discount-value" class="text-white font-semibold">0.00 €</span>
    </p>

    @if($hasVAT)
    <p class="text-sm text-gray-400">
      TVA ({{ $vatRate }}%) :
      <span id="vat" class="text-white font-semibold">0.00 €</span>
    </p>
    @endif

    <p class="text-lg font-bold text-primary">
      Total TTC : <span id="total" class="font-bold">0.00 €</span>
    </p>
  </div>
</x-form.section>