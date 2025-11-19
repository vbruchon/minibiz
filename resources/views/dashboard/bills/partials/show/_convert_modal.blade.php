@props([
'paymentLabels' => [],
'billId' => null, // null = mode dynamique (index)
])

<x-modal id="convert-modal" size="max-w-md">
  <h2 class="text-2xl font-bold mb-6">Convertir en facture</h2>

  <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
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

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Ajouter une note (optionnel)
      </label>

      <textarea
        name="conversion_note"
        rows="3"
        class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-2 border border-gray-300 dark:border-gray-600"
        placeholder="Merci pour votre confiance..."></textarea>
    </div>

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