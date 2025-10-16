<div id="{{ $id }}" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-lg max-w-4xl w-full p-6 relative">
        <button id="{{ $id }}-close" class="absolute top-3 right-3 text-gray-400 hover:text-gray-200">✕</button>

        <div id="{{ $id }}-content">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    (function() {
        const modal = document.getElementById('{{ $id }}');
        const modalContent = document.getElementById('{{ $id }}-content');
        const closeBtn = document.getElementById('{{ $id }}-close');

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        modal.addEventListener('click', e => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        document.querySelectorAll(`[data-modal-target="{{ $id }}"]`).forEach(btn => {
            btn.addEventListener('click', () => {
                const contentId = btn.dataset.modalContentId;
                if (contentId) {
                    const template = document.getElementById(contentId);
                    if (template) {
                        modalContent.innerHTML = template.innerHTML;
                    }
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
    })();
</script>