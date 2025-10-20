@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Details')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mx-auto mt-2 px-8 py-4 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Product Details</h1>
  </div>

  <div class="space-y-6">
    @include('dashboard.products.partials._product_info')
    @includeWhen($product->type === 'package', 'dashboard.products.partials._linked_options_table')
  </div>

  @include('dashboard.products.partials._modals')

</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const showModal = document.getElementById('productOptionModal');
    const contentContainer = showModal.querySelector(`#${showModal.id}-content`);

    const showTemplate = (templateId) => {
      const template = document.getElementById(templateId);
      if (!template) return;
      contentContainer.innerHTML = template.innerHTML;

      attachEditButtons();
      attachBackButtons();
      attachAddValueBtn();
    };

    const attachEditButtons = () => {
      contentContainer.querySelectorAll('.edit-option-btn').forEach(editBtn => {
        editBtn.addEventListener('click', () => {
          const optionId = editBtn.dataset.optionId;
          showTemplate(`option-edit-template-${optionId}`);
        });
      });
    };

    const attachBackButtons = () => {
      contentContainer.querySelectorAll('[data-action="back-to-show"]').forEach(btn => {
        btn.addEventListener('click', () => {
          const optionId = btn.dataset.optionId;
          showTemplate(`option-template-${optionId}`);
        });
      });
    };

    const attachAddValueBtn = () => {
      const valuesList = contentContainer.querySelector('div.space-y-4'); // conteneur des valeurs
      if (!valuesList) return;

      const addValueBtn = contentContainer.querySelector('#addValueBtn');
      if (!addValueBtn) return;

      addValueBtn.addEventListener('click', () => {
        const index = valuesList.querySelectorAll('input[type="text"]').length;
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center mt-2';
        div.innerHTML = `
        <input type="text" name="values[${index}][value]" placeholder="Value" class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
        <input type="number" name="values[${index}][price]" placeholder="Price (€)" step="0.01" class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
        <input type="radio" name="default_index" value="${index}" title="Default" class="cursor-pointer" />
        <button type="button" class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</button>
      `;
        valuesList.appendChild(div);

        div.querySelector('.removeValue').addEventListener('click', () => {
          div.remove();
        });
      });
    };

    document.querySelectorAll('[data-modal-content-id]').forEach(btn => {
      btn.addEventListener('click', () => {
        const templateId = btn.dataset.modalContentId;
        showTemplate(templateId);
        showModal.classList.remove('hidden');
        showModal.classList.add('flex');
      });
    });

    const manageModal = document.getElementById('manageOptionsModal');
    document.getElementById('manageOptionsBtn').addEventListener('click', () => {
      manageModal.classList.remove('hidden');
      manageModal.classList.add('flex');
    });

    [showModal, manageModal].forEach(modal => {
      modal.addEventListener('click', e => {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    });

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        [showModal, manageModal].forEach(modal => {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        });
      }
    });
  });
</script>
@endsection