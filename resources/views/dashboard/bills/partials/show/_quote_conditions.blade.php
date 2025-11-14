<div>
  <div class="grid grid-cols-2 text-sm text-gray-700 leading-relaxed gap-8">
    <div class="space-y-0.5">
      <h4 class="text-lg font-medium mb-4">Conditions</h4>

      <div class="flex items-center gap-4">
        <p class="font-semibold text-gray-900">Conditions de règlement :</p>
        <p>
          {{ $bill->payment_terms 
          ? ucfirst($bill->payment_terms)
          : 'Non spécifié' }}
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

    <div class="space-y-0.5 justify-self-start">
      <h4 class="text-lg font-medium mb-4">Bon pour accord</h4>
      <p class="mt-2">À ............................................., le .... / .... / ........</p>
      <div class="mt-4 space-y-1">
        <p>Signature et cachet :</p>
        <div class="h-26 border border-dashed border-gray-400 rounded-md mt-2"></div>
        <p class="text-xs text-gray-500 mt-6">Qualité du signataire : .............................................,</p>
      </div>
    </div>
  </div>
</div>