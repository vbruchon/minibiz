@props([
'href',
'icon',
'label'
])

<li>
  <a href="{{ $href }}"
    class="flex items-center gap-2 px-3 py-2 rounded-lg 
              hover:bg-sidebar-accent transition-colors">
    <x-dynamic-component :component="$icon" class="size-5" />
    <span>{{ $label }}</span>
  </a>
</li>