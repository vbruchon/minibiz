@props([
'href' => null,
'type' => 'button',
'variant' => 'default', // default | primary | outline | secondary | ghost | destructive
'size' => 'md', // sm | md | lg
'disabled' => false,
])

@php
$base = 'inline-flex items-center justify-center transition-colors font-semibold rounded-lg hover:scale-105 transition hover:cursor-pointer';

$variants = [
'default' => 'text-indigo-400 hover:text-indigo-300 hover:underline',
'primary' => 'bg-primary text-white shadow hover:bg-primary/90',
'outline' => 'border border-gray-600 text-white hover:bg-gray-700/40',
'secondary' => 'bg-gray-700 text-white hover:bg-gray-600',
'ghost' => 'bg-transparent text-gray-300 hover:text-white',
'destructive' => 'bg-destructive/70 text-white hover:bg-destructive/60 !rounded',
'info' => 'bg-blue-500/70 text-white shadow hover:bg-blue-500/80',
];

$sizes = [
'sm' => 'px-3 py-1.5 text-sm',
'md' => 'px-5 py-2.5 text-base',
'lg' => 'px-6 py-3 text-lg',
];

$variantClass = $variants[$variant] ?? $variants['default'];
$sizeClass = $sizes[$size] ?? $sizes['sm'];
$disabledClass = $disabled ? 'opacity-50 pointer-events-none' : '';

$classes = trim("{$base} {$variantClass} {$sizeClass} {$disabledClass}");
@endphp


@if($href)
<a
  href="{{ $disabled ? '#' : $href }}"
  @if($disabled) aria-disabled="true" tabindex="-1" onclick="event.preventDefault();" @endif
  {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</a>
@else
<button
  type="{{ $type }}"
  @if($disabled) disabled @endif
  {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</button>
@endif