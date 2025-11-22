@props(['type'])

@php
$map = [
'quote' => [
'label' => 'Quote',
'icon' => 'document-text',
'color' => 'warning',
],
'invoice' => [
'label' => 'Invoice',
'icon' => 'receipt-percent',
'color' => 'primary',
],
];

$cfg = $map[$type] ?? null;
@endphp

@if ($cfg)
<span class="inline-flex items-center gap-1 px-2 py-1 rounded-md border text-sm
             bg-{{ $cfg['color'] }}/15 text-{{ $cfg['color'] }} border-{{ $cfg['color'] }}/30">
  @svg("heroicon-o-{$cfg['icon']}", 'size-4')
  {{ $cfg['label'] }}
</span>
@endif