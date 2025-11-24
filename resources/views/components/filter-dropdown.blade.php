@props([
'name',
'label' => null,
'options' => [],
'route',
])

@php
$current = request($name);
$label = $label ?? ucfirst($name);
@endphp

<div class="relative">
  <button
    type="button"
    class="flex items-center justify-between gap-3 px-3 py-1.5
               bg-input border border-border text-foreground rounded-lg
               hover:bg-muted/10 focus:ring-2 focus:ring-primary transition"
    data-dropdown-btn="{{ $name }}">
    <span>{{ $options[$current] ?? $label }}</span>

    <x-heroicon-o-chevron-down
      class="size-4 ml-2 transition-transform"
      data-dropdown-chevron="{{ $name }}" />
  </button>

  {{-- DROPDOWN MENU --}}
  <div
    class="absolute hidden z-20 mt-2 min-w-[180px] bg-card border border-border rounded-lg
               shadow-lg overflow-hidden"
    data-dropdown-menu="{{ $name }}">
    <form action="{{ $route }}" method="GET">
      @foreach(request()->except($name) as $key => $value)
      <input type="hidden" name="{{ $key }}" value="{{ $value }}">
      @endforeach

      <ul class="text-foreground">
        <li>
          <button
            type="button"
            class="block w-full text-left px-4 py-2 hover:bg-muted/20"
            onclick="window.filterClear('{{ $name }}')">
            Tous
          </button>
        </li>

        @foreach($options as $value => $text)
        <li>
          <button
            type="submit"
            name="{{ $name }}"
            value="{{ $value }}"
            class="block w-full text-left px-4 py-2 hover:bg-muted/20
                                   {{ $current === $value ? 'bg-muted/10 text-primary font-semibold' : '' }}">
            {{ $text }}
          </button>
        </li>
        @endforeach
      </ul>
    </form>
  </div>
</div>