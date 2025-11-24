@props(['type'])

@php
$map = [
'quote' => [
'label' => 'Devis',
'icon' => 'document-text',
'color' => 'warning',
],
'invoice' => [
'label' => 'Facture',
'icon' => 'receipt-percent',
'color' => 'primary',
],
];

$cfg = $map[$type] ?? null;
@endphp

@if ($cfg)
<x-badge
  :label="$cfg['label']"
  :icon="$cfg['icon']"
  :color="$cfg['color']"
  class="min-w-22" />
@endif