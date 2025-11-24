<x-card title="Activité Récente">
  @forelse ($recentActivity as $bill)
  <div class="group p-4 border border-border rounded-lg bg-muted/10 transition grid grid-cols-[1fr_auto_auto] gap-6 items-center">
    <div class="flex items-center gap-4">
      @if($bill->isQuote())
      <div class="p-2 rounded-full bg-muted/20 border border-border">
        <x-heroicon-o-document-text class="size-5 text-muted-foreground" />
      </div>
      @else
      <div class="p-2 rounded-full bg-primary/20 border border-border">
        <x-heroicon-o-document-check class="size-5 text-primary" />
      </div>
      @endif

      <a href="{{ route('dashboard.bills.show', $bill->id) }}">
        <p class="text-foreground font-medium">
          {{ $bill->typeLabel() }} #{{ $bill->number }}
        </p>
        <p class="text-sm text-muted-foreground">
          {{ $bill->created_at->format('d/m/Y') }} —
          {{ $bill->customer?->company_name ?? 'Client supprimé' }}
        </p>
      </a>
    </div>

    <x-bill.status-badge :bill="$bill" />

    <a href="{{ route('dashboard.bills.show', $bill->id) }}">
      <x-heroicon-o-eye class="size-5 text-muted-foreground opacity-0 transition group-hover:opacity-100" />
    </a>
  </div>

  @empty
  <p class="text-muted-foreground italic">Aucune activité récente.</p>
  @endforelse

</x-card>