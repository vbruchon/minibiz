<div class="relative inline-block">
    {{-- 🔹 Bouton principal --}}
    <button type="button"
        class="relative flex items-center justify-center border {{ $statusColor }}
           hover:brightness-110 hover:shadow-sm transition focus:outline-none focus:ring-2 focus:ring-primary/40
           {{ count($allowedStatuses) > 0 ? 'cursor-pointer' : 'cursor-default' }}
           {{ $isShow ? 'px-3.5 py-0.5 pr-5 rounded-full text-xs font-medium capitalize' : 'w-28 rounded-md px-3 py-1.5 text-sm pr-6' }}"
        @if(count($allowedStatuses)> 0)
        onclick="toggleStatusMenu({{ $bill->id }})"
        @endif>

        <span class="mx-auto">{{ $bill->status->label() }}</span>

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