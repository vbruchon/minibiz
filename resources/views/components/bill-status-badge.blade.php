@props(['bill'])

@php
$status = $bill->status->value;
$allowedStatuses = app(\App\Services\BillStatusService::class)->allowedNextStatuses($bill);

$statusColor = match($status) {
'draft' => 'bg-gray-600/10 text-gray-400 border-gray-500/30',
'sent' => 'bg-blue-600/10 text-blue-400 border-blue-500/30',
'accepted' => 'bg-green-600/10 text-green-400 border-green-500/30',
'rejected' => 'bg-red-600/10 text-red-400 border-red-500/30',
'converted' => 'bg-yellow-600/10 text-yellow-400 border-yellow-500/30',
'paid' => 'bg-emerald-600/10 text-emerald-400 border-emerald-500/30',
'overdue' => 'bg-orange-600/10 text-orange-400 border-orange-500/30',
'cancelled' => 'bg-red-600/10 text-red-400 border-red-500/30',
default => 'bg-gray-600/10 text-gray-400 border-gray-500/30'
};

$hoverColor = match($status) {
'draft' => 'hover:bg-gray-700',
'sent' => 'hover:bg-blue-700/40',
'accepted' => 'hover:bg-green-700/40',
'rejected' => 'hover:bg-red-700/40',
'converted' => 'hover:bg-yellow-700/40',
'paid' => 'hover:bg-emerald-700/40',
'overdue' => 'hover:bg-orange-700/40',
'cancelled' => 'hover:bg-red-700/40',
default => 'hover:bg-gray-700'
};
@endphp

<div class="relative inline-block">
  {{-- 🔹 Bouton principal --}}
  <button type="button"
    class="relative flex items-center justify-center w-28 px-3 py-1.5 text-sm rounded-md border {{ $statusColor }}
           hover:brightness-110 hover:shadow-sm transition focus:outline-none focus:ring-2 focus:ring-primary/40
           {{ count($allowedStatuses) > 0 ? 'cursor-pointer pr-6' : 'cursor-default' }}"
    @if(count($allowedStatuses)> 0)
    onclick="toggleStatusMenu({{ $bill->id }})"
    @endif>

    {{-- Texte centré --}}
    <span class="mx-auto">{{ ucfirst($status) }}</span>

    {{-- Chevron à droite --}}
    @if (count($allowedStatuses) > 0)
    <x-heroicon-o-chevron-down
      class="absolute right-2 top-1/2 -translate-y-1/2 size-3 text-gray-400 pointer-events-none" />
    @endif
  </button>

  {{-- 🔹 Menu déroulant --}}
  @if (count($allowedStatuses) > 0)
  <div id="status-menu-{{ $bill->id }}"
    class="hidden absolute left-0 mt-2 w-32 bg-gray-800 border border-gray-700 rounded-lg shadow-lg z-50 overflow-hidden">
    <form method="POST" action="{{ route('dashboard.bills.update-status', $bill) }}">
      @csrf
      @method('PATCH')
      @foreach ($allowedStatuses as $nextStatus)
      <button type="submit" name="status" value="{{ $nextStatus }}"
        class="block w-full text-left px-3 py-2 text-sm text-gray-200 {{ $hoverColor }} hover:text-primary transition">
        {{ ucfirst($nextStatus) }}
      </button>
      @endforeach
    </form>
  </div>
  @endif
</div>

@once
@push('scripts')
<script>
  function toggleStatusMenu(id) {
    const menu = document.getElementById(`status-menu-${id}`);
    document.querySelectorAll('[id^="status-menu-"]').forEach(el => {
      if (el !== menu) el.classList.add('hidden');
    });
    if (menu) menu.classList.toggle('hidden');
  }

  document.addEventListener('click', (e) => {
    const isInside = e.target.closest('[id^="status-menu-"], button[onclick^="toggleStatusMenu"]');
    if (!isInside) {
      document.querySelectorAll('[id^="status-menu-"]').forEach(el => el.classList.add('hidden'));
    }
  });
</script>
@endpush
@endonce