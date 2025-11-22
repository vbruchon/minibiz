@props([
'paymentLabels' => [],
'billId' => null,
])

<x-modal id="convert-modal" size="max-w-md">
  <h2 class="text-2xl font-bold mb-6">Convertir en facture</h2>

  <p class="text-sm text-muted-foreground mb-4">
    Choisissez le mode de paiement à utiliser.
  </p>

  <form id="convert-form"
    method="POST"
    @if($billId)
    action="{{ route('dashboard.bills.convert', $billId) }}"
    @endif
    class="space-y-6">

    @csrf

    <div class="space-y-2">
      @foreach($paymentLabels as $method => $label)
      <label class="flex items-center gap-2 cursor-pointer">
        <input type="radio" name="payment_method" value="{{ $method }}">
        <span>{{ $label }}</span>
      </label>
      @endforeach
    </div>

    <x-form.textarea
      label="Ajouter une note"
      name="conversion_note"
      placeholder="Merci pour votre confiance..."
      rows="3"
      optional>{{ old('footer_note', $company->footer_note ?? '') }}</x-form.textarea>

    <x-button type="submit" variant="warning" class="w-full">
      Convertir
    </x-button>
  </form>
</x-modal>


@push('scripts')
<script>
  window.initModalContent = (content) => {
    const ribInfo = content.querySelector("#rib-info");
    const radios = content.querySelectorAll('input[name="payment_method"]');

    if (!radios.length || !ribInfo) return;

    radios.forEach(radio => {
      radio.addEventListener("change", () => {
        if (radio.value === "bank_transfer") {
          ribInfo.classList.remove("hidden");
        } else {
          ribInfo.classList.add("hidden");
        }
      });
    });
  };
</script>
@endpush