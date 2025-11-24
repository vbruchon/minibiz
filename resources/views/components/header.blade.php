@props([
'title',
])

<div class="flex items-center justify-between mb-6">
  <h1 class="text-3xl font-bold text-foreground">
    {{ $title }}
  </h1>

  @if(isset($actions))
  <div class="flex items-center gap-3">
    {{ $actions }}
  </div>
  @endif
</div>