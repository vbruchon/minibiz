@props(['status'])

@php
$map = [
'active' => 'success',
'inactive' => 'muted',
'prospect' => 'warning',
];

$color = $map[$status] ?? 'muted';
@endphp

<x-badge
  :label="ucfirst($status)"
  :color="$color"
  size="md"
  class="w-24 text-center" />