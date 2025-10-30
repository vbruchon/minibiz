@props(['type'])

@if ($type === 'quote')
<span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 text-sm">
  <x-heroicon-o-document-text class="size-4" /> Quote
</span>
@elseif ($type === 'invoice')
<span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-blue-600/20 text-blue-400 border border-blue-500/30 text-sm">
  <x-heroicon-o-receipt-percent class="size-4" /> Invoice
</span>
@endif