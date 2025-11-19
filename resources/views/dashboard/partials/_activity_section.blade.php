<div>
  <div class="border border-gray-700 bg-gray-900/70 rounded-xl p-6 space-y-6">
    <h2 class="text-lg font-semibold text-gray-300">
      Activité Récente
    </h2>

    @forelse ($recentActivity as $bill)
    <div class="group p-4 border border-gray-700 rounded-lg bg-gray-900/40 hover:bg-gray-900/60 transition grid grid-cols-[1fr_auto_auto] gap-6 items-center">
      <div class="flex items-center gap-4">
        <div class="p-2 rounded-full bg-gray-800 border border-gray-700">
          @if($bill->isQuote())
          <x-heroicon-o-document-text class="size-5 text-gray-300" />
          @else
          <x-heroicon-o-document-check class="size-5 text-primary" />
          @endif
        </div>

        <a href="{{ route('dashboard.bills.show', $bill->id) }}">
          <p class="text-gray-200 font-medium">
            {{ $bill->typeLabel() }} #{{ $bill->number }}
          </p>
          <p class="text-sm text-gray-500">
            {{ $bill->created_at->format('d/m/Y') }} —
            {{ $bill->customer?->company_name ?? 'Client supprimé' }}
          </p>
        </a>
      </div>

      <x-bill.status-badge :bill="$bill" />

      <a href="{{ route('dashboard.bills.show', $bill->id) }}">
        <x-heroicon-o-eye class="size-5 text-gray-300 opacity-0 transition group-hover:opacity-100" />
      </a>

    </div>


    @empty
    <p class="text-gray-500 italic">Aucune activité récente.</p>
    @endforelse

  </div>

</div>