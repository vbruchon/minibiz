@props([
'id',
'showCloseBtn' => true,
'size' => 'max-w-3xl',
])

<div
    id="{{ $id }}"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 backdrop-blur-sm"
    data-modal>
    <div
        class="bg-card border border-border rounded-2xl shadow-xl w-full {{ $size }} mx-4 p-6 relative overflow-y-auto max-h-[90vh]"
        data-modal-dialog>

        @if ($showCloseBtn)
        <button
            type="button"
            class="absolute top-3 right-3 text-muted-foreground hover:text-foreground transition"
            data-modal-close>
            ✕
        </button>
        @endif

        <div class="modal-content text-foreground">
            {{ $slot }}
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    window.ModalSystem = {
        init() {
            const modals = document.querySelectorAll('[data-modal]');

            const openModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;

                // Run custom code if needed
                if (typeof window.initModalContent === 'function') {
                    window.initModalContent(modal.querySelector('.modal-content'));
                }

                modals.forEach((m) => m.classList.add('hidden'));
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = (modal) => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            // open button
            document.querySelectorAll('[data-modal-target]').forEach((btn) => {
                btn.addEventListener('click', () => openModal(btn.dataset.modalTarget));
            });

            // click outside closes
            modals.forEach((modal) => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal(modal);
                });

                modal.querySelectorAll('[data-modal-close]').forEach((btn) => {
                    btn.addEventListener('click', () => closeModal(modal));
                });
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    modals.forEach(closeModal);
                }
            });
        }
    };

    document.addEventListener('DOMContentLoaded', window.ModalSystem.init);
</script>
@endpush
@endonce