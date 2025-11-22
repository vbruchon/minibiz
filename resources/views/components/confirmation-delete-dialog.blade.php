@props([
'modelId',
'modelName' => 'item',
'route',
'variant' => 'destructive',
'customClass' => null,
])

<div class="inline" id="deleteWrapper-{{ $modelId }}">
    <x-button
        id="deleteBtn-{{ $modelId }}"
        variant="{{ $variant }}"
        size="sm"
        class="{{ $customClass }}">
        {{ $slot }}
    </x-button>

    <div
        id="deleteModal-{{ $modelId }}"
        class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-card border border-border p-6 rounded-xl max-w-lg w-full shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-foreground">
                Confirmation avant supression
            </h2>

            <p class="mb-6 text-muted-foreground">
                Etes vous sûre de supprimer ce {{ $modelName }}?
            </p>

            <div class="flex justify-end gap-4">
                <x-button
                    id="cancelBtn-{{ $modelId }}"
                    variant="secondary"
                    size="sm"
                    class="!rounded">
                    Retour
                </x-button>

                <form action="{{ route($route, $modelId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="destructive" size="sm">
                        Supprimer
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        const id = "{{ $modelId }}";
        const deleteBtn = document.getElementById(`deleteBtn-${id}`);
        const cancelBtn = document.getElementById(`cancelBtn-${id}`);
        const modal = document.getElementById(`deleteModal-${id}`);

        if (!deleteBtn || !cancelBtn || !modal) return;

        deleteBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    })();
</script>
@endpush