<div
  id="converted-banner"
  class="converted-banner
         fixed bottom-6 right-6 z-50
         p-4 pr-6 bg-blue-50 border-l-4 border-primary text-blue-900 rounded-md shadow-lg text-sm
         flex items-center gap-1
         opacity-0 translate-x-20
         transition-all duration-300 ease-out">

  <button
    id="close-converted-banner"
    class="absolute top-2 right-2 text-blue-500 hover:text-blue-700 text-lg leading-none hover:cursor-pointer">
    ×
  </button>

  <x-heroicon-o-information-circle class="size-6 text-blue-600 animate-pulse" />

  <p class="font-medium">
    Ce devis a déjà été converti en
    <a href="{{ route('dashboard.bills.show', $bill->convertedInvoice->id) }}"
      class="underline font-semibold hover:text-blue-700">
      facture #{{ $bill->convertedInvoice->number }}
    </a>.
  </p>
</div>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("converted-banner");
    const closeBtn = document.getElementById("close-converted-banner");

    if (!el) return;

    // --- Slide-in ---
    el.classList.add("opacity-0", "translate-x-20");
    el.classList.remove("opacity-100", "translate-x-0");
    void el.offsetWidth;
    el.classList.remove("opacity-0", "translate-x-20");
    el.classList.add("opacity-100", "translate-x-0");

    // --- Slide-out on close ---
    closeBtn.addEventListener("click", () => {
      el.classList.remove("opacity-100", "translate-x-0");
      el.classList.add("opacity-0", "translate-x-20");

      setTimeout(() => el.remove(), 300);
    });
  });
</script>
@endpush