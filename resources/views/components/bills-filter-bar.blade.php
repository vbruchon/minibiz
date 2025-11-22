@props([
'route',
'types' => ['quote' => 'Devis', 'invoice' => 'Facture'],
'currentType' => null,
'statuses' => [],
'currentStatus' => null,
])

@php
$hasFilter = $currentType || $currentStatus;
@endphp

<div class="flex items-center gap-3 mb-3">
  <div class="relative">
    <button id="typeDropdownBtn" type="button"
      class="flex items-center justify-between gap-3 px-3 py-1.5 bg-card border border-border text-foreground rounded-lg hover:bg-muted/10 transition">
      <span>{{ $types[$currentType] ?? 'Type' }}</span>
      <x-heroicon-o-chevron-down class="size-4 transition" id="typeDropdownChevron" />
    </button>

    <div id="typeDropdownMenu"
      class="absolute hidden z-20 min-w-[180px] bg-card border border-border rounded-lg shadow-lg overflow-hidden">
      <form action="{{ $route }}" method="GET">
        @if($currentStatus)
        <input type="hidden" name="status" value="{{ $currentStatus }}">
        @endif
        @if(request('s'))
        <input type="hidden" name="s" value="{{ request('s') }}">
        @endif

        <ul class="text-foreground">
          <li>
            <button type="button"
              class="block w-full text-left px-4 py-2 hover:bg-muted/10"
              onclick="clearFilter('type')">Tous</button>
          </li>

          @foreach ($types as $key => $label)
          <li>
            <button type="submit" name="type" value="{{ $key }}"
              class="block w-full text-left px-4 py-2 hover:bg-muted/10 {{ $currentType === $key ? 'bg-muted/10 text-primary font-semibold' : '' }}">
              {{ $label }}
            </button>
          </li>
          @endforeach
        </ul>
      </form>
    </div>
  </div>

  <div class="relative">
    <button id="statusDropdownBtn" type="button"
      class="flex items-center justify-between gap-3 px-3 py-1.5 bg-card border border-border text-foreground rounded-lg hover:bg-muted/10 transition">
      <span>{{ $currentStatus ? ucfirst($currentStatus) : 'Statut' }}</span>
      <x-heroicon-o-chevron-down class="size-4 transition" id="statusDropdownChevron" />
    </button>

    <div id="statusDropdownMenu"
      class="absolute hidden z-20 min-w-[180px] bg-card border border-border rounded-lg shadow-lg overflow-hidden">
      <form action="{{ $route }}" method="GET">
        @if($currentType)
        <input type="hidden" name="type" value="{{ $currentType }}">
        @endif
        @if(request('s'))
        <input type="hidden" name="s" value="{{ request('s') }}">
        @endif

        <ul class="text-foreground">
          <li>
            <button type="button" class="block w-full text-left px-4 py-2 hover:bg-muted/10"
              onclick="clearFilter('status')">Tous</button>
          </li>

          @foreach ($statuses as $status)
          <li>
            <button type="submit" name="status" value="{{ $status->value }}"
              class="block w-full text-left px-4 py-2 hover:bg-muted/10 {{ $currentStatus === $status->value ? 'bg-muted/10 text-primary font-semibold' : '' }}">
              {{ ucfirst($status->value) }}
            </button>
          </li>
          @endforeach
        </ul>
      </form>
    </div>
  </div>

  @if($hasFilter)
  <button type="button"
    class="px-3 py-1 border border-border text-foreground rounded-lg hover:bg-muted/20 transition -translate-y-1/5"
    onclick="resetAllFilters()">
    Réinitialiser
  </button>
  @endif
</div>

@push('scripts')
<script>
  const dropdowns = [{
      btn: 'typeDropdownBtn',
      menu: 'typeDropdownMenu',
      chevron: 'typeDropdownChevron'
    },
    {
      btn: 'statusDropdownBtn',
      menu: 'statusDropdownMenu',
      chevron: 'statusDropdownChevron'
    },
  ];

  dropdowns.forEach(d => {
    const btn = document.getElementById(d.btn);
    const menu = document.getElementById(d.menu);
    const chevron = document.getElementById(d.chevron);

    btn.addEventListener('click', () => {
      const open = !menu.classList.contains('hidden');
      menu.classList.toggle('hidden', open);
      chevron.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
    });
  });

  document.addEventListener('click', e => {
    dropdowns.forEach(d => {
      const btn = document.getElementById(d.btn);
      const menu = document.getElementById(d.menu);
      const chevron = document.getElementById(d.chevron);

      if (!btn.contains(e.target) && !menu.contains(e.target)) {
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
      url.pathname + '?' + params.toString() :
      url.pathname;
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
@endpush