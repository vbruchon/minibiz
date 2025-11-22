@props([
'route',
'products' => [],
'currentProduct' => null,
'types' => [],
'currentType' => null,
])

@php
$hasFilter = $currentProduct || $currentType;
@endphp

<div class="flex items-center gap-4">
  <div class="relative">
    <button
      id="productDropdownBtn"
      type="button"
      class="flex items-center justify-between gap-3 px-3 py-1.5 bg-input border border-border text-foreground rounded-lg focus:ring-2 focus:ring-primary transition w-40">
      <span id="productDropdownLabel">
        {{ $products[$currentProduct] ?? 'Product' }}
      </span>
      <x-heroicon-o-chevron-down
        id="productDropdownChevron"
        class="size-4 ml-2 transition-transform" />
    </button>

    <div
      id="productDropdownMenu"
      class="absolute z-20 mt-2 w-48 bg-card border border-border rounded-lg shadow-lg hidden">
      <form action="{{ $route }}" method="GET">
        {{-- preserve other filters --}}
        @if($currentType)
        <input type="hidden" name="type" value="{{ $currentType }}">
        @endif
        @if(request('s'))
        <input type="hidden" name="s" value="{{ request('s') }}">
        @endif

        <ul class="text-foreground">
          <li>
            <button type="button"
              onclick="clearFilter('product_id')"
              class="w-full px-4 py-2 text-left hover:bg-muted/20">
              All
            </button>
          </li>

          @foreach ($products as $id => $name)
          <li>
            <button type="submit"
              name="product_id"
              value="{{ $id }}"
              class="w-full px-4 py-2 text-left hover:bg-muted/20
                                           {{ $currentProduct == $id ? 'text-primary font-semibold' : '' }}">
              {{ $name }}
            </button>
          </li>
          @endforeach
        </ul>
      </form>
    </div>
  </div>

  <div class="relative">
    <button
      id="typeDropdownBtn"
      type="button"
      class="flex items-center justify-between gap-3 px-3 py-1.5 bg-input border border-border text-foreground rounded-lg focus:ring-2 focus:ring-primary transition w-32">
      <span id="typeDropdownLabel">
        {{ $currentType ? ucfirst($currentType) : 'Type' }}
      </span>
      <x-heroicon-o-chevron-down
        id="typeDropdownChevron"
        class="size-4 ml-2 transition-transform" />
    </button>

    <div
      id="typeDropdownMenu"
      class="absolute z-20 mt-2 w-36 bg-card border border-border rounded-lg shadow-lg hidden">
      <form action="{{ $route }}" method="GET">
        @if($currentProduct)
        <input type="hidden" name="product_id" value="{{ $currentProduct }}">
        @endif
        @if(request('s'))
        <input type="hidden" name="s" value="{{ request('s') }}">
        @endif

        <ul class="text-foreground">
          <li>
            <button type="button"
              onclick="clearFilter('type')"
              class="w-full px-4 py-2 text-left hover:bg-muted/20">
              All
            </button>
          </li>

          @foreach($types as $type)
          <li>
            <button type="submit"
              name="type"
              value="{{ $type }}"
              class="w-full px-4 py-2 text-left hover:bg-muted/20
                                           {{ $currentType === $type ? 'text-primary font-semibold' : '' }}">
              {{ ucfirst($type) }}
            </button>
          </li>
          @endforeach
        </ul>
      </form>
    </div>
  </div>

  @if($hasFilter)
  <button
    type="button"
    onclick="resetAllFilters()"
    class="px-3 py-1.5 border border-border text-foreground rounded-lg hover:bg-muted/20 transition">
    Reset filters
  </button>
  @endif
</div>


@push('scripts')
<script>
  const dropdowns = [{
      btn: 'productDropdownBtn',
      menu: 'productDropdownMenu',
      chevron: 'productDropdownChevron'
    },
    {
      btn: 'typeDropdownBtn',
      menu: 'typeDropdownMenu',
      chevron: 'typeDropdownChevron'
    },
  ];

  dropdowns.forEach(d => {
    const btn = document.getElementById(d.btn);
    const menu = document.getElementById(d.menu);
    const chevron = document.getElementById(d.chevron);

    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
      const open = !menu.classList.contains('hidden');
      menu.classList.toggle('hidden', open);
      chevron.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
    });
  });

  document.addEventListener('click', (e) => {
    dropdowns.forEach(d => {
      const btn = document.getElementById(d.btn);
      const menu = document.getElementById(d.menu);
      const chevron = document.getElementById(d.chevron);

      if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
      }
    });
  });

  function clearFilter(name) {
    const url = new URL("{{ $route }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);
    params.delete(name);

    window.location.href = params.toString() ?
      `${url.pathname}?${params.toString()}` :
      url.pathname;
  }

  function resetAllFilters() {
    const url = new URL("{{ $route }}", window.location.origin);
    const search = new URLSearchParams(window.location.search).get('s');

    window.location.href = search ? `${url.pathname}?s=${search}` : url.pathname;
  }
</script>
@endpush