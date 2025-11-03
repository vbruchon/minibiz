@props(['bill'])

@php
$statusColor = match($bill->status->value) {
'draft' => 'bg-gray-600/10 text-gray-400 border-gray-500/30',
'sent' => 'bg-blue-600/10 text-blue-400 border-blue-500/30',
'accepted' => 'bg-green-600/10 text-green-400 border-green-500/30',
'rejected' => 'bg-red-600/10 text-red-400 border-red-500/30',
'converted' => 'bg-yellow-600/10 text-yellow-400 border-yellow-500/30',
'paid' => 'bg-emerald-600/10 text-emerald-400 border-emerald-500/30',
'overdue' => 'bg-orange-600/10 text-orange-400 border-orange-500/30',
'cancelled' => 'bg-red-600/10 text-red-400 border-red-500/30',
default => 'bg-gray-600/10 text-gray-400 border-gray-500/30'
};
@endphp

<tr class="hover:bg-gray-700/40 transition-colors group">
  <td class="px-6 py-3 text-gray-200 font-medium">
    {{ $bill->number }}
  </td>

  <td class="px-6 py-3 text-gray-300">
    <x-bill-type-badge :type="$bill->type" />
  </td>

  <td class="px-6 py-3 relative">
    <x-bill-status-badge :bill="$bill" />

  </td>

  <td class="px-6 py-3 text-gray-300">
    {{ $bill->customer?->company_name ?? '—' }}
  </td>

  <td class="px-6 py-3 text-gray-200 font-medium">
    {{ number_format($bill->total, 2, ',', ' ') }} €
  </td>

  <td class="px-6 py-3 text-gray-300">
    {{ $bill->issue_date?->format('d/m/Y') ?? '—' }}
  </td>

  <td class="px-6 py-3 flex items-center">
    <x-button :href="route('dashboard.bills.index', $bill->id)" variant="ghost" size="sm">
      <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
    </x-button>

    @if($bill->status->value === 'draft')
    <x-button :href="route('dashboard.bills.index', $bill->id)" variant="ghost" size="sm">
      <x-heroicon-o-pencil-square class="size-5 text-blue-400 hover:text-blue-500 transition opacity-0 group-hover:opacity-100" />
    </x-button>

    <x-confirmation-delete-dialog
      :modelId="$bill->id"
      modelName="bill"
      route="dashboard.bills.index"
      variant="ghost">
      <x-heroicon-o-trash class="size-5 text-destructive mt-1 hover:text-destructive/70 hover:cursor-pointer transition opacity-0 group-hover:opacity-100" />
    </x-confirmation-delete-dialog>
    @endif
  </td>
</tr>