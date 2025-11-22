@props(['bill'])

@php
$status = $bill->status->value;

$colors = [
'draft' => 'bg-muted/15 text-muted-foreground border-muted/40',
'sent' => 'bg-blue-500/15 text-blue-600 border-blue-500/30',
'accepted' => 'bg-green-500/15 text-green-600 border-green-500/30',
'rejected' => 'bg-red-500/15 text-red-600 border-red-500/30',
'converted' => 'bg-yellow-500/15 text-yellow-600 border-yellow-500/30',
'paid' => 'bg-emerald-500/15 text-emerald-600 border-emerald-500/30',
'overdue' => 'bg-orange-500/15 text-orange-600 border-orange-500/30',
'cancelled' => 'bg-red-700/15 text-red-700 border-red-700/30',
];
@endphp

<tr class="hover:bg-muted/10 transition-colors group">

  {{-- Numéro --}}
  <td class="px-6 py-3 text-foreground font-medium">
    {{ $bill->number }}
  </td>

  {{-- Type --}}
  <td class="px-6 py-3 text-muted-foreground">
    <x-bill-type-badge :type="$bill->type" />
  </td>

  {{-- Status --}}
  <td class="px-6 py-3 relative">
    <x-bill.status-badge :bill="$bill" />
  </td>

  {{-- Customer --}}
  <td class="px-6 py-3 text-muted-foreground">
    {{ $bill->customer?->company_name ?? '—' }}
  </td>

  {{-- Total --}}
  <td class="px-6 py-3 text-foreground font-medium">
    {{ number_format($bill->total, 2, ',', ' ') }} €
  </td>

  {{-- Issue date --}}
  <td class="px-6 py-3 text-muted-foreground">
    {{ $bill->issue_date?->format('d/m/Y') ?? '—' }}
  </td>


  {{-- Actions --}}
  <td class="px-6 py-3 flex items-center gap-1">

    {{-- Voir --}}
    <x-tooltip-button label="Voir">
      <x-button :href="route('dashboard.bills.show', $bill->id)" variant="ghost" size="sm">
        <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
      </x-button>
    </x-tooltip-button>

    {{-- Modifier --}}
    @if($bill->canBeEdited())
    <x-tooltip-button label="Modifier">
      <x-button :href="route('dashboard.bills.edit', $bill->id)" variant="ghost" size="sm">
        <x-heroicon-o-pencil-square class="size-5 text-primary transition opacity-0 group-hover:opacity-100" />
      </x-button>
    </x-tooltip-button>
    @endif

    {{-- Convertir --}}
    @if($bill->canBeConverted())
    <x-tooltip-button label="Convertir">
      <x-button
        data-modal-target="convert-modal"
        data-bill-id="{{ $bill->id }}"
        variant="ghost"
        size="sm">
        <x-heroicon-o-document-arrow-down class="size-5 text-warning transition opacity-0 group-hover:opacity-100" />
      </x-button>
    </x-tooltip-button>
    @endif

    {{-- Exporter PDF --}}
    <x-tooltip-button label="Exporter PDF">
      <x-button href="{{ route('dashboard.bills.pdf', $bill) }}" variant="ghost" size="sm">
        <x-heroicon-o-arrow-down-tray class="size-5 text-primary transition opacity-0 group-hover:opacity-100" />
      </x-button>
    </x-tooltip-button>

    {{-- Supprimer --}}
    @if($bill->canBeEdited())
    <x-tooltip-button label="Supprimer">
      <x-confirmation-delete-dialog
        :modelId="$bill->id"
        modelName="bill"
        route="dashboard.bills.delete"
        variant="ghost">
        <x-heroicon-o-trash
          class="size-5 text-destructive transition opacity-0 group-hover:opacity-100" />
      </x-confirmation-delete-dialog>
    </x-tooltip-button>
    @endif

  </td>
</tr>