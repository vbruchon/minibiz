@props([
'route' => route('customers.index'),
'currentStatus' => request('status'),
'options' => [
'active' => 'Active',
'prospect' => 'Prospect',
'inactive' => 'Inactive',
],
])

<div class="relative mb-4">
    <button id="statusDropdownBtn"
        type="button"
        class="flex items-center justify-between gap-3 w-fit px-3 py-1.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition">
        <span id="statusDropdownLabel">{{ $options[$currentStatus] ?? 'Status' }}</span>
        <x-heroicon-o-chevron-down id="statusDropdownChevron" class="size-4 ml-2 transition-transform" />
    </button>

    <div id="statusDropdownMenu"
        class="absolute z-20 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-lg shadow-lg overflow-hidden hidden">
        <form action="{{ $route }}" method="GET" id="filterBarDropdown">
            <ul class="text-gray-200">
                <li>
                    <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-700 transition hover:cursor-pointer"
                        onclick="clearStatus()">
                        All
                    </button>
                </li>
                @foreach ($options as $value => $label)
                <li>
                    <button type="submit" name="status" value="{{ $value }}"
                        class="block w-full text-left px-4 py-2 hover:bg-gray-700 hover:cursor-pointer transition {{ $currentStatus === $value ? 'bg-gray-700 text-primary font-bold' : '' }}">
                        {{ $label }}
                    </button>
                </li>
                @endforeach
            </ul>
        </form>
    </div>
</div>

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