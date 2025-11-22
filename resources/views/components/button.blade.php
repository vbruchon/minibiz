@props([
'href' => null,
'type' => 'button',
'variant' => 'default', // default | primary | outline | secondary | ghost | destructive
'size' => 'md', // sm | md | lg
'disabled' => false,
'class' => null
])

@php
$base = 'inline-flex items-center justify-center transition-colors font-semibold rounded-lg hover:scale-105 transition hover:cursor-pointer';

$variants = [
'default' => 'text-indigo-400 hover:text-indigo-300 hover:underline',
'primary' => 'bg-primary text-white shadow hover:bg-primary/90',
'outline' => 'border border-foreground/50 text-foreground hover:bg-muted/30',
'secondary' => 'bg-accent text-foreground hover:bg-accent/40',
'ghost' => 'bg-transparent text-muted-foreground hover:text-foreground',
'destructive' => 'bg-destructive/70 text-white hover:bg-destructive/60',
'info' => 'bg-blue-500/70 text-white shadow hover:bg-blue-500/80',
'warning' => 'bg-warning/90 text-white shadow hover:bg-amber-500/80',
];

$sizes = [
'icon' => 'size-9 p-0',
'sm' => 'px-3 py-1.5 text-sm',
'md' => 'px-5 py-2.5 text-base',
'lg' => 'px-6 py-3 text-lg',
];

$variantClass = $variants[$variant] ?? $variants['default'];
$sizeClass = $sizes[$size] ?? $sizes['sm'];
$disabledClass = $disabled ? 'opacity-50 pointer-events-none' : '';

$classes = trim("{$base} {$variantClass} {$sizeClass} {$disabledClass} transition-all duration-300");
@endphp


@if($href)
<a
  href="{{ $disabled ? '#' : $href }}"
  @if($disabled) aria-disabled="true" tabindex="-1" onclick="event.preventDefault();" @endif
  class="{{ $classes }} {{ $class ?? '' }}"
  {{ $attributes }}>
  {{ $slot }}
</a>
@else
<button
  type="{{ $type }}"
  @if($disabled) disabled @endif
  class="{{ $classes }} {{ $class ?? '' }}"
  {{ $attributes }}>
  {{ $slot }}
</button>
@endif