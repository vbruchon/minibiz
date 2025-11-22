@props([
'route',
'currentStatus' => request('status'),
'options' => [],
])

<div class="relative mb-4">
    <button id="statusDropdownBtn"
        class="flex items-center justify-between gap-3 px-3 py-1.5 bg-input border border-border text-foreground rounded-lg focus:ring-2 focus:ring-primary transition hover:cursor-pointer">
        <span id="statusDropdownLabel">{{ $options[$currentStatus] ?? 'Status' }}</span>
        <x-heroicon-o-chevron-down id="statusDropdownChevron" class="size-4 ml-2 transition-transform" />
    </button>

    <div id="statusDropdownMenu"
        class="absolute z-20 mt-2 w-40 bg-card border border-border rounded-lg shadow-lg hidden">
        <ul class="text-foreground">
            <li>
                <button type="button"
                    class="block w-full text-left px-4 py-2 hover:bg-muted/20">
                    Tous
                </button>
            </li>

            @foreach ($options as $value => $label)
            <li>
                <button type="submit" name="status" value="{{ $value }}"
                    class="block w-full text-left px-4 py-2 hover:bg-muted/20 {{ $currentStatus === $value ? 'text-primary font-semibold' : '' }}">
                    {{ $label }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>

</div>
@section('scripts')
<script>
    const dropdownBtn = document.getElementById('statusDropdownBtn');
    const dropdownMenu = document.getElementById('statusDropdownMenu');
    const dropdownChevron = document.getElementById('statusDropdownChevron');

    dropdownBtn.addEventListener('click', () => {
        const isOpen = !dropdownMenu.classList.contains('hidden');
        dropdownMenu.classList.toggle('hidden', isOpen);
        dropdownChevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    });

    document.addEventListener('click', (e) => {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
            dropdownChevron.style.transform = 'rotate(0deg)';
        }
    });

    function clearStatus() {
        const url = new URL("{{ $route }}", window.location.origin);
        const params = new URLSearchParams(window.location.search);
        params.delete('status');

        window.location.href = params.toString() ? url.pathname + '?' + params.toString() : url.pathname;
    }
</script>
@endsection