@props(['company' => null])

<x-form.section title="Paramètres de paiement" :separator="false">

  @php
  $methods = $company->payment_methods ?? [];
  @endphp

  <div class="flex items-center gap-12">
    <label class="flex items-center space-x-3">
      <input
        type="checkbox"
        name="payment_methods[]"
        value="bank_transfer"
        class="h-5 w-5 rounded border-gray-600 bg-gray-800 text-primary focus:ring-primary"
        {{ in_array('bank_transfer', old('payment_methods', $methods)) ? 'checked' : '' }}>
      <span class="text-gray-200">Virement bancaire</span>
    </label>

    <label class="flex items-center space-x-3">
      <input
        type="checkbox"
        name="payment_methods[]"
        value="cash"
        class="h-5 w-5 rounded border-gray-600 bg-gray-800 text-primary focus:ring-primary"
        {{ in_array('cash', old('payment_methods', $methods)) ? 'checked' : '' }}>
      <span class="text-gray-200">Espèces</span>
    </label>

    <label class="flex items-center space-x-3">
      <input
        type="checkbox"
        name="payment_methods[]"
        value="cheque"
        class="h-5 w-5 rounded border-gray-600 bg-gray-800 text-primary focus:ring-primary"
        {{ in_array('cheque', old('payment_methods', $methods)) ? 'checked' : '' }}>
      <span class="text-gray-200">Chèques</span>
    </label>

  </div>

  {{-- RIB --}}
  <div id="rib-container" class="{{ $errors->has('bank_iban') || $errors->has('bank_bic') ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <x-form.input
        label="IBAN"
        name="bank_iban"
        placeholder="FR76 3000 4000 1234 5678 9012 345"
        :value="old('bank_iban', $company->bank_iban ?? '')" />
      <x-form.input
        label="BIC"
        name="bank_bic"
        placeholder="BNPAFRPP"
        :value="old('bank_bic', $company->bank_bic ?? '')" />
    </div>

    <p class="text-xs text-gray-400 mt-2">
      Le RIB est affiché uniquement pour les factures avec paiement par virement.
    </p>
  </div>
</x-form.section>

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const bankTransferCheckbox = document.querySelector(
      'input[name="payment_methods[]"][value="bank_transfer"]'
    );

    const ribContainer = document.getElementById("rib-container");

    if (!bankTransferCheckbox || !ribContainer) return;

    const updateRibVisibility = () => {
      if (bankTransferCheckbox.checked) {
        ribContainer.classList.remove("hidden");
      } else {
        ribContainer.classList.add("hidden");
      }
    };

    updateRibVisibility();

    bankTransferCheckbox.addEventListener("change", updateRibVisibility);
  });
</script>
@endsection