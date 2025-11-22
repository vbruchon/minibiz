@props([
'title' => '',
'status' => null,
])

<div class="bg-card border border-border rounded-xl shadow-sm p-6">
  <div class="flex items-center justify-between mb-6 pb-2 border-b border-border">
    <h2 class="text-lg font-semibold text-foreground">{{ $title }}</h2>

    @if($status)
    @php
    $s = strtolower(trim($status));
    $colors = [
    'active' => 'bg-success/15 text-success border-success/30',
    'inactive' => 'bg-muted/20 text-muted-foreground border-muted/40',
    'prospect' => 'bg-warning/15 text-warning border-warning/30',
    ];
    @endphp

    <span class="px-3 py-1.5 text-sm rounded-md border {{ $colors[$s] ?? $colors['inactive'] }}">
      {{ ucfirst($s) }}
    </span>
    @endif
  </div>

  {{ $slot }}
</div>