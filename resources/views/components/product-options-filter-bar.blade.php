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

<div class="flex items-center gap-3">
  {{-- Filtre Product --}}
  <div class="relative mb-4">
    <button id="productDropdownBtn" type="button"
      class="flex items-center justify-between gap-3  px-3 py-1.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition">
      <span id="productDropdownLabel">{{ $products[$currentProduct] ?? 'Product' }}</span>
      <x-heroicon-o-chevron-down id="productDropdownChevron" class="size-4 ml-2 transition-transform" />
    </button>

    <div id="productDropdownMenu" class="absolute z-20 mt-2 min-w-[200px] bg-gray-800 border border-gray-700 rounded-lg shadow-lg overflow-hidden hidden">
      <form action="{{ $route }}" method="GET">
        @if($currentType)
        <input type="hidden" name="type" value="{{ $currentType }}">
        @endif
        @if(request('s'))
        <input type="hidden" name="s" value="{{ request('s') }}">
        @endif

        <ul class="text-gray-200 w-full">
          <li>
            <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-700"
              onclick="clearFilter('product_id')">All</button>
          </li>
          @foreach ($products as $id => $name)
          <li>
            <button type="submit" name="product_id" value="{{ $id }}"
              class="block w-full text-left px-4 py-2 hover:bg-gray-700 {{ $currentProduct == $id ? 'bg-gray-700 text-primary font-bold' : '' }}">
              {{ $name }}
            </button>
          </li>
          @endforeach
        </ul>
      </form>
    </div>
  </div>

  {{-- Filtre Type --}}
  <div class="relative mb-4">
    <button id="typeDropdownBtn" type="button"
      class="flex items-center justify-between gap-3  px-3 py-1.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition">
      <span id="typeDropdownLabel">{{ $currentType ? ucfirst($currentType) : 'Type' }}</span>
      <x-heroicon-o-chevron-down id="typeDropdownChevron" class="size-4 ml-2 transition-transform" />
    </button>

    <div id="typeDropdownMenu" class="absolute z-20 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-lg shadow-lg overflow-hidden hidden">
      <form action="{{ $route }}" method="GET">
        @if($currentProduct)
        <input type="hidden" name="product_id" value="{{ $currentProduct }}">
        @endif
        @if(request('s'))
        <input type="hidden" name="s" value="{{ request('s') }}">
        @endif

        <ul class="text-gray-200">
          <li>
            <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-700"
              onclick="clearFilter('type')">All</button>
          </li>
          @foreach($types as $type)
          <li>
            <button type="submit" name="type" value="{{ $type }}"
              class="block w-full text-left px-4 py-2 hover:bg-gray-700 {{ $currentType === $type ? 'bg-gray-700 text-primary font-bold' : '' }}">
              {{ ucfirst($type) }}
            </button>
          </li>
          @endforeach
        </ul>
      </form>
    </div>
  </div>


  @if($hasFilter)
  <div class="-translate-y-1/5">
    <button type="button"
      class="px-3 py-1 border-2 border-gray-600 text-gray-200 rounded-lg hover:bg-gray-500 transition"
      onclick="resetAllFilters()">
      Reset filters
    </button>
  </div>
  @endif

</div>

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

    if (btn && menu && chevron) {
      btn.addEventListener('click', () => {
        const isOpen = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden', isOpen);
        chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
      });
    }
  });

  document.addEventListener('click', (e) => {
    dropdowns.forEach(d => {
      const btn = document.getElementById(d.btn);
      const menu = document.getElementById(d.menu);
      const chevron = document.getElementById(d.chevron);
      if (btn && menu && chevron && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
      }
    });
  });

  function clearFilter(name) {
    const url = new URL("{{ $route }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);
    params.delete(name);
    window.location.href = params.toString() ? url.pathname + '?' + params.toString() : url.pathname;
  }

  function resetAllFilters() {
    const url = new URL("{{ $route }}", window.location.origin);
    const params = new URLSearchParams(window.location.search);

    const search = params.get('s');

    const newParams = new URLSearchParams();
    if (search) newParams.set('s', search);

    window.location.href = newParams.toString() ?
      `${url.pathname}?${newParams.toString()}` :
      url.pathname;
  }
</script>