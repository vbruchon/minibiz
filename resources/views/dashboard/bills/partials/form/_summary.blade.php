<x-form.section :title="$type === 'invoice' ? 'Résumé de la facture' : 'Résumé du devis'">
  <div class="p-4 border rounded-lg bg-muted/10 text-right space-y-1">
    <p class="text-sm text-muted-foreground">Sous-total :
      <span id="subtotal" class="text-foreground font-semibold">0.00 €</span>
    </p>
    <p class="text-sm text-muted-foreground">
      Remise globale :
      <span id="discount-value" class="text-foreground font-semibold">0.00 €</span>
    </p>

    @if($hasVAT)
    <p class="text-sm text-muted-foreground">
      TVA ({{ $vatRate }}%) :
      <span id="vat" class="text-foreground font-semibold">0.00 €</span>
    </p>
    @endif

    <p class="text-lg font-bold text-primary">
      Total TTC : <span id="total" class="font-bold">0.00 €</span>
    </p>
  </div>
</x-form.section>