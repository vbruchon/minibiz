<x-modal id="convert-modal" size="max-w-md">
  <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">
    Convertir en facture
  </h2>

  <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
    Choisissez le mode de paiement à utiliser pour cette facture.
  </p>

  <form id="convert-form"
    method="POST"
    action="{{ route('dashboard.bills.convert', $bill->id) }}"
    class="space-y-6">
    @csrf

    <div class="space-y-2">
      @foreach($bill->company->payment_methods ?? [] as $method)
      <label class="flex items-center gap-2 cursor-pointer">
        <input
          type="radio"
          name="payment_method"
          value="{{ $method }}"
          class="h-4 w-4 text-primary border-gray-400">
        <span class="text-gray-800 dark:text-gray-200">
          {{ $paymentLabels[$method] ?? ucfirst($method) }}
        </span>
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
        class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 border border-gray-300 dark:border-gray-600 focus:ring-primary focus:border-primary resize-none"
        placeholder="Merci pour votre confiance..."></textarea>

      <p class="text-xs text-gray-500 mt-1">
        Cette note apparaîtra en bas de la facture.
      </p>
    </div>

    <x-button type="submit" variant="warning" class="w-full justify-center">
      Convertir en facture
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