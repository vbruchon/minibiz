@props(['label' => 'Retour'])

<x-button
  type="button"
  variant="secondary"
  size="sm"
  onclick="
    window.history.back();
    window.addEventListener('pageshow', function() {
        history.replaceState(null, '', location.href);
        location.reload();
    }, { once: true });
"
  {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
  <x-heroicon-s-arrow-left class="size-4" />
  <span>{{ $label }}</span>
</x-button>