@props([
'label',
'color' => 'primary',
'icon' => null,
'size' => 'md', // sm | md
'rounded' => 'md', // md | full
'class' => ''
])

@php
$sizes = [
'sm' => 'px-2 py-0.5 text-xs gap-1',
'md' => 'px-3 py-1.5 text-sm gap-1',
];

$roundings = [
'md' => 'rounded-md',
'full' => 'rounded-full',
];
@endphp

<span class="inline-flex items-center justify-center border
    bg-{{ $color }}/15 text-{{ $color }} border-{{ $color }}/30
    {{ $sizes[$size] }}
    {{ $roundings[$rounded] }}
    {{ $class }}">
  @if ($icon)
  @svg("heroicon-o-$icon", "size-4")
  @endif

  {{ $label }}
</span>