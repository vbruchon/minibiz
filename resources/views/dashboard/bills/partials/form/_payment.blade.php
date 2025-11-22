@if ($type === 'invoice')
<x-form.section title="Paiement">
  <p class="text-sm text-muted-foreground mb-4">
    Choisissez le mode de paiement utilisé pour cette facture.
  </p>
  <div class="grid grid-cols-2">
    <div class="space-y-3">
      @foreach($company->payment_methods ?? [] as $method)
      <label class="flex items-center gap-2 cursor-pointer">
        <input
          type="radio"
          name="payment_method"
          value="{{ $method }}"
          class="h-4 w-4 text-primary border-gray-400"
          {{ old('payment_method', $bill->payment_method ?? null) === $method ? 'checked' : '' }}
          <span class="text-muted-foreground">
        {{ $paymentLabels[$method] ?? ucfirst($method) }}
        </span>
      </label>
      @endforeach
    </div>

    <div id="payment-extra" class="space-y-3 hidden">
      <div id="extra-bank" class="hidden space-y-2">
        <p class="text-sm italic text-muted-foreground">Informations pour le virement :</p>
        <div class="text-muted-foreground">
          <p><strong>IBAN :</strong> {{ $company->bank_iban }}</p>
          <p><strong>BIC :</strong> {{ $company->bank_bic }}</p>
        </div>
      </div>

      <div id="extra-cheque" class="hidden space-y-2">
        <p class="text-sm italic text-muted-foreground">Informations pour le chèque :</p>
        <p class="text-muted-foreground ">
          <strong>Ordre :</strong> {{ $company->company_name }}<br>
          <strong>Adresse :</strong> {{ $company->full_address }}
        </p>
      </div>

      <div id="extra-cash" class="hidden">
        <p class="text-muted-foreground">Le paiement doit être remis en main propre.</p>
      </div>
    </div>
  </div>

</x-form.section>
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    const wrapper = document.getElementById('payment-extra');

    const blocks = {
      bank_transfer: document.getElementById('extra-bank'),
      cheque: document.getElementById('extra-cheque'),
      cash: document.getElementById('extra-cash'),
    };

    radios.forEach((r) => {
      r.addEventListener('change', () => {
        wrapper.classList.remove('hidden');

        Object.values(blocks).forEach(el => el.classList.add('hidden'));

        if (blocks[r.value]) {
          blocks[r.value].classList.remove('hidden');
        }
      });

      if (r.checked && blocks[r.value]) {
        wrapper.classList.remove('hidden');
        blocks[r.value].classList.remove('hidden');
      }
    });
  });
</script>
@endpush
@endif