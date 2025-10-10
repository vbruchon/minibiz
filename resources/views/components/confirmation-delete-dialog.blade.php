@props([
'customerId',
'variant'
])

<div class="inline" id="deleteWrapper-{{ $customerId }}">
    <x-button id="deleteBtn-{{ $customerId }}" variant="{{ $variant}}" size="sm">
        {{ $slot }}
    </x-button>


    <div id="deleteModal-{{ $customerId }}" class="fixed inset-0 items-center justify-center bg-black/50 z-50 hidden">
        <div class="bg-gray-800 p-6 rounded-lg max-w-sm w-full">
            <h2 class="text-xl font-bold mb-6 text-white">Confirm deletion</h2>
            <p class="mb-6 text-gray-200">Are you sure you want to delete this customer?</p>
            <div class="flex justify-end gap-4">
                <x-button id="cancelBtn-{{ $customerId }}" variant="secondary" size="sm" class="!rounded">Cancel</x-button>

                <form action="{{ route('customers.delete', $customerId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="destructive" size="sm">Delete</x-button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const wrapperId = "{{ $customerId }}";
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