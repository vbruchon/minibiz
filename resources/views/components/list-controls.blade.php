@props([
'route',
'searchName' => 's',
'searchPlaceholder' => 'Rechercher...',
'filters' => [],
])

<div class="flex items-center gap-6 mb-6 w-full">
  <div class="flex-1">
    <x-search-bar
      :route="$route"
      :name="$searchName"
      :placeholder="$searchPlaceholder" />
  </div>

  <div class="flex items-center gap-3 mb-3">
    @foreach($filters as $filter)
    <x-filter-dropdown
      :name="$filter['name']"
      :label="$filter['label'] ?? null"
      :options="$filter['options']"
      :route="route($route)" />
    @endforeach

    @if(collect($filters)->contains(fn($f) => request($f['name'])))
    <x-button type="button" variant="ghost" size="icon"
      onclick="window.filterReset('{{ route($route) }}')">
      <x-heroicon-s-x-mark class="size-4" />
    </x-button>
    @endif
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-dropdown-btn]').forEach(btn => {
      const name = btn.dataset.dropdownBtn;
      const menu = document.querySelector(`[data-dropdown-menu="${name}"]`);
      const chevron = document.querySelector(`[data-dropdown-chevron="${name}"]`);

      btn.addEventListener('click', () => {
        const isOpen = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden', isOpen);
        chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
      });
    });

    // close when clicking outside
    document.addEventListener('click', e => {
      document.querySelectorAll('[data-dropdown-menu]').forEach(menu => {
        if (!menu.contains(e.target) &&
          !document.querySelector(`[data-dropdown-btn="${menu.dataset.dropdownMenu}"]`)?.contains(e.target)) {
          menu.classList.add('hidden');
          const chevron = document.querySelector(`[data-dropdown-chevron="${menu.dataset.dropdownMenu}"]`);
          if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
      });
    });

    window.filterClear = function(name) {
      const params = new URLSearchParams(window.location.search);
      params.delete(name);
      const url = new URL(window.location.href);
      url.search = params.toString();
      window.location.href = url.toString();
    }

    window.filterReset = function(route) {
      const params = new URLSearchParams(window.location.search);
      const search = params.get('{{ $searchName }}');
      const url = new URL(route, window.location.origin);
      if (search) url.search = `{{ $searchName }}=${search}`;
      window.location.href = url.toString();
    }
  });
</script>
@endpush