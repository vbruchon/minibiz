<div class="grid grid-cols-2 text-sm leading-relaxed gap-8">
  <div class="space-y-2">
    <h4 class="text-lg font-medium mb-4 text-gray-900">Conditions</h4>

    <div class="flex items-center gap-4">
      <p class="font-semibold text-gray-900">Conditions de règlement :</p>
      <p>
        {{ $bill->payment_terms ? ucfirst($bill->payment_terms) : 'Non spécifié' }}
      </p>
    </div>

    <div class="flex items-center gap-4">
      <p class="font-semibold text-gray-900">Mode de paiement :</p>
      <p>
        {{ $bill->payment_label }}
      </p>
    </div>

    <div class="flex items-center gap-4">
      <p class="font-semibold text-gray-900">Intérêts de retard :</p>
      <p>
        @if(is_numeric($bill->interest_rate))
        {{ rtrim(rtrim(number_format($bill->interest_rate, 2, '.', ''), '0'), '.') }}%
        @else
        {{ ucfirst($bill->interest_rate) }}
        @endif
      </p>
    </div>
  </div>

  @if($bill->payment_method === 'cash')
  <p class="text-gray-700">Le paiement doit être remis en main propre.</p>
  @endif
  <div class="space-y-2">
    <h4 class="text-lg font-medium mb-4 text-gray-900">Informations paiements</h4>
    @if($bill->payment_method === 'bank_transfer')
    <div class="mt-2 space-y-1 text-gray-700">
      <p><span class="font-semibold">IBAN :</span> {{ $bill->company->bank_iban }}</p>
      <p><span class="font-semibold">BIC :</span> {{ $bill->company->bank_bic }}</p>
    </div>
    @endif

    @if($bill->payment_method === 'cheque')
    <div class="mt-2 space-y-1 text-gray-700">
      <p><span class="font-semibold">Ordre :</span> {{ $bill->company->company_name }}</p>
      <p><span class="font-semibold">Envoyé à :</span> {{ $bill->company->full_address }}</p>
    </div>
    @endif
  </div>

</div>