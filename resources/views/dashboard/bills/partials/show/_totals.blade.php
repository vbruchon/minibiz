<div class="space-y-2.5">
  @if($bill->company->footer_note)
  <p class="text-sm italic text-gray-500 text-right whitespace-pre-line">{{ $bill->company->footer_note }}</p>
  @endif
  <div class="flex justify-end">
    <div class="w-1/3 text-right space-y-1 text-sm">
      <div class="flex justify-between text-gray-600">
        <span>Sous-total :</span>
        <span>{{ number_format($bill->subtotal, 2, ',', ' ') }} €</span>
      </div>

      @if($bill->discount_percentage > 0)
      <div class="flex justify-between text-gray-600">
        <span>Remise ({{ $bill->discount_percentage }}%) :</span>
        <span>-{{ $bill->discount_amount }} €</span>
      </div>
      @endif

      @if($bill->company->vat_number)
      <div class="flex justify-between text-gray-600">
        <span>TVA :</span>
        <span>-{{ $bill->default_tax_rate }} €</span>
      </div>
      @endif

      <div class="flex justify-between font-semibold border-t border-gray-300 pt-2 mt-2">
        <span>Total TTC :</span>
        <span class="text-lg">{{ number_format($bill->total, 2, ',', ' ') }} €</span>
      </div>
    </div>
  </div>
</div>