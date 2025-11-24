@props([
'icon',
'label',
'value',
'iconBg' => 'bg-muted/20',
'iconColor' => 'text-muted-foreground',
'padding' => 'p-3',
])

<div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
  <div class="{{ $padding }} rounded-full {{ $iconBg }} border border-border">
    <x-dynamic-component :component="$icon" class="size-6 {{ $iconColor }}" />
  </div>

  <div>
    <p class="text-sm font-medium text-muted-foreground">{{ $label }}</p>
    <p class="text-2xl font-bold text-foreground leading-tight">
      {{ $value }}
    </p>
  </div>
</div>