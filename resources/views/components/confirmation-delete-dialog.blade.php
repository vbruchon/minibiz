@props([
'modelId',
'modelName' => 'item',
'route',
'variant' => 'destructive',
'customClass' => null
])

<div class="inline" id="deleteWrapper-{{ $modelId }}">
    <x-button id="deleteBtn-{{ $modelId }}" variant="{{ $variant }}" size="sm" class="{{$customClass}}">
        {{ $slot }}
    </x-button>

    <div id="deleteModal-{{ $modelId }}" class="fixed inset-0 items-center justify-center bg-black/50 z-50 hidden">
        <div class="bg-gray-800 p-6 rounded-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-6 text-white">Confirm deletion</h2>
            <p class="mb-6 text-gray-200">Are you sure you want to delete this {{ $modelName }}?</p>
            <div class="flex justify-end gap-4">
                <x-button id="cancelBtn-{{ $modelId }}" variant="secondary" size="sm" class="!rounded">Cancel</x-button>

                <form action="{{ route($route, $modelId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="destructive" size="sm">Delete</x-button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        const wrapperId = "{{ $modelId }}";
        const deleteBtn = document.getElementById(`deleteBtn-${wrapperId}`);
        const cancelBtn = document.getElementById(`cancelBtn-${wrapperId}`);
        const modal = document.getElementById(`deleteModal-${wrapperId}`);

        if (!deleteBtn || !cancelBtn || !modal) return;

        deleteBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    })();
</script>
@endpush