@props(['label', 'value' => null])

<div class="w-full space-y-1">
  <p class="text-sm font-medium text-foreground">{{ $label }}</p>

  <div class="w-full bg-muted/10 border border-border rounded-md px-4 py-2.5 text-sm text-foreground">
    {{ $value ?: '—' }}
  </div>
</div>