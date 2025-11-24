@props([
'title' => null,
'padding' => 'p-6',
'class' => '',
])

<div {{ $attributes->merge([
    'class' =>
        "bg-card border border-border rounded-xl shadow-sm {$padding} space-y-6 " . $class
]) }}>
  @if($title)
  <h2 class="text-lg font-semibold text-foreground">{{ $title }}</h2>
  @endif

  {{ $slot }}
</div>