@props([
'route', // route name for the form
'placeholder' => 'Search...', // placeholder text
'name' => 's', // query param name
])

<div class="mb-4">
    <form id="searchForm" action="{{ route($route) }}" method="GET">
        <div class="relative w-[90%]">
            <input
                id="searchInput"
                type="text"
                name="{{ $name }}"
                value="{{ request($name) }}"
                placeholder="{{ $placeholder }}"
                class="border border-muted rounded-lg px-3 py-2 pr-8 w-full">

            <button
                id="delete-search-btn"
                type="button"
                onclick="document.getElementById('searchInput').value=''; toggleClearButton(); document.getElementById('searchForm').submit();"
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hover:cursor-pointer">
                <x-heroicon-o-x-mark class="size-4" />
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('searchInput');
        const clearBtn = document.getElementById('delete-search-btn');
        const form = document.getElementById('searchForm');
        let debounceTimer;

        window.toggleClearButton = () => {
            clearBtn.classList.toggle('hidden', input.value === '');
        }

        input.addEventListener('input', () => {
            toggleClearButton();

            // 🔁 autosubmit with debounce 500ms
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                form.submit();
            }, 500);
        });

        clearBtn.addEventListener("click", () => {
            input.value = '';

            const params = new URLSearchParams(window.location.search);
            params.delete('{{ $name }}');

            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');

            window.location.href = newUrl;

        });

        toggleClearButton();
    });
</script>
@endsection