@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Details')

@section('content')
<div class="mx-auto">

  {{-- Back button --}}
  <x-button :href="route('dashboard.products.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" /> Back
  </x-button>

  {{-- Product Header --}}
  <div class="mx-auto mt-2 p-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Product Details</h1>
  </div>

  <div class="space-y-8">

    {{-- Product Info --}}
    <x-show-info title="Product Info">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-detail-field label="Product Name" :value="$product->name" />
        <x-detail-field label="Type" :value="$product->type === 'time_unit' ? 'Time Unit' : 'Package'" />
        @if($product->unit)
        <x-detail-field label="Unit" :value="$product->unit" />
        @endif
        <x-detail-field label="Base Price (€)" :value="number_format($product->base_price, 2)" />
      </div>
    </x-show-info>

    @if($product->type === 'package')
    <x-show-info title="Linked Options">
      @if($product->options->isEmpty())
      <div class="text-sm text-gray-400 italic">No options linked to this product yet.</div>
      @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-700 rounded-lg">
          <thead class="bg-gray-800 text-gray-300 uppercase text-xs">
            <tr>
              <th class="px-4 py-2 text-left">Option Name</th>
              <th class="px-4 py-2 text-left">Type</th>
              <th class="px-4 py-2 text-left">Default Value</th>
              <th class="px-4 py-2 text-left">Default Price (€)</th>
              <th class="px-4 py-2 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-700">
            @foreach($product->options as $option)
            <tr>
              <td class="px-4 py-2 text-gray-100">{{ $option->name }}</td>
              <td class="px-4 py-2 text-gray-300">{{ ucfirst($option->type) }}</td>
              <td class="px-4 py-2 text-gray-300">{{ $option->default_value }}</td>
              <td class="px-4 py-2 text-gray-300">{{ number_format($option->default_price, 2) }}</td>
              <td class="px-4 py-2 text-right">
                <button type="button"
                  data-modal-target="productOptionModal"
                  data-modal-content-id="option-template-{{ $option->id }}"
                  class="text-gray-400 hover:text-gray-200">
                  <x-heroicon-o-eye class="size-4 cursor-pointer" />
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      {{-- Manage Options Button --}}
      <x-button type="button" variant="outline" size="sm" id="manageOptionsBtn" class="!text-gray-400 mt-4">
        <x-heroicon-o-cog class="size-6" /> Manage Options
      </x-button>
    </x-show-info>
    @endif
  </div>

  {{-- Templates pour Show Option Modal --}}
  @foreach($product->options as $option)
  <template id="option-template-{{ $option->id }}">
    <div class="space-y-6">
      <h2 class="text-2xl font-bold mb-4">{{ $option->name }}</h2>
      <div class="grid grid-cols-2 gap-6">
        <x-detail-field label="Option Name" :value="$option->name" />
        <x-detail-field label="Type" :value="ucfirst($option->type)" />
      </div>

      @if($option->type === 'text' || $option->type === 'number')
      <div class="grid grid-cols-3 gap-6 mt-4">
        <x-detail-field label="Default Value" :value="$option->pivot->default_value ?? '-'" />
        <x-detail-field label="Default Price (€)" :value="number_format($option->pivot->default_price ?? 0, 2)" />
        <x-detail-field label="Attached by Default" :value="$option->pivot->is_default_attached ? '✅ Yes' : '❌ No'" />
      </div>
      @endif

      @if($option->values->count())
      <div class="space-y-4 mt-2">
        <h3>Option Values</h3>
        @foreach($option->values as $value)
        <div class="flex flex-col md:flex-row items-center justify-between w-full rounded-xl gap-4">
          <x-detail-field label="Value" :value="$value->value" class="w-full" />
          <x-detail-field label="Price (€)" :value="number_format($value->price ?? 0, 2)" />
          <x-detail-field label="Default" :value="$value->is_default ? '✅ Yes' : '❌ No'" />
        </div>
        @endforeach
      </div>
      @endif
      <div class="flex justify-end mb-2">
        <x-button class="edit-option-btn" variant="info" size="sm" data-option-id="{{ $option->id }}">Edit</x-button>
      </div>
    </div>
  </template>

  {{-- Template edit formulaire inline --}}
  <template id="option-edit-template-{{ $option->id }}">
    <form method="POST" action="{{ route('dashboard.products-options.update', $option->id) }}">
      @csrf
      @method('PUT')
      <div class="space-y-6">
        <h2 class="text-2xl font-bold mb-4">Edit Option: {{ $option->name }}</h2>

        <div class="mb-8">
          <div class="hidden">
            @foreach($packageProducts as $id => $name)
            <label class="inline-flex items-center gap-1.5 text-gray-200">
              <input
                type="checkbox"
                name="product_id[]"
                value="{{ $id }}"
                id="product_{{ $id }}"
                @if(in_array($id, old('product_id', $option?->products->pluck('id')->toArray() ?? []))) checked @endif
              class="w-4 h-4 rounded border-gray-600 bg-gray-700 focus:ring-2 focus:ring-primary">
              <span>{{ $name }}</span>
            </label>
            @endforeach
          </div>

          @error('product_id')
          <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
          @enderror
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
          {{-- Option Name --}}
          <x-form.input
            label="Option Name"
            name="name"
            type="text"
            :value="$option->name"
            required />

          {{-- Option Type --}}
          <x-form.select
            label="Type"
            name="type"
            :options="['text' => 'Text', 'number' => 'Number', 'select' => 'Select']"
            :selected="$option->type"
            required />
        </div>

        {{-- For text/number type: default value + price + attached by default --}}
        @if($option->type === 'text' || $option->type === 'number')
        <div class="grid grid-cols-3 gap-6">
          <x-form.input
            label="Default Value"
            name="default_value"
            type="text"
            :value="$option->pivot->default_value ?? ''" />

          <x-form.input
            label="Default Price (€)"
            name="default_price"
            type="number"
            :value="$option->pivot->default_price ?? 0"
            step="0.01" />

          <x-form.select
            label="Attached by Default"
            name="is_default_attached"
            :options="['0' => 'No', '1' => 'Yes']"
            :selected="$option->pivot->is_default_attached ? '1' : '0'" />
        </div>
        @endif

        {{-- Values list for select type --}}
        @if($option->values->count())
        <div id="valuesList" class="space-y-4 mt-4">
          <h3 class="font-semibold">Option Values</h3>
          @foreach($option->values as $value)
          <div class="flex gap-2 items-center">
            <input type="text" name="values[{{ $value->id }}][value]" value="{{ $value['value'] }}"
              placeholder="Value"
              class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
            <input type="number" name="values[{{ $value->id }}][price]" value="{{ $value['price'] ?? 0 }}" step="0.01"
              placeholder="Price (€)"
              class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
            <input type="radio" name="default_index" value="{{ $value->id }}" title="Default" class="cursor-pointer"
              {{ $value->id == $value->is_default ? 'checked' : '' }} />
            <x-button type="button" variant="ghost" size="sm"
              class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
          </div>
          @endforeach
        </div>
        <x-button type="button" id="addValueBtn" variant="ghost" size="md" class="!text-blue-500 hover:!text-blue-700 !px-0">
          + Add Value
        </x-button>
        @endif

        <div class="flex justify-end gap-2 mt-4">
          <x-button
            type="button"
            variant="secondary"
            size="sm"
            data-action="back-to-show"
            data-option-id="{{ $option->id }}">
            Cancel
          </x-button>

          <x-button type="submit" variant="primary" size="sm">
            Save Changes
          </x-button>
        </div>
      </div>
    </form>
  </template>

  @endforeach

  {{-- Show Option Modal --}}
  <x-modal id="productOptionModal">
    <div id="productOptionModal-content"></div>
  </x-modal>

  {{-- Manage Options Modal --}}
  <x-modal id="manageOptionsModal">
    <div class="p-6 space-y-4">
      <h2 class="text-xl font-bold py-4">Manage Product Options</h2>
      <form method="POST" action="{{ route('dashboard.products-options.sync', $product->id) }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          @foreach($allOptions as $option)
          <label class="flex items-center gap-2">
            <input type="checkbox" name="options[]" value="{{ $option->id }}"
              {{ $product->options->contains($option) ? 'checked' : '' }}>
            {{ $option->name }} ({{ ucfirst($option->type) }})
          </label>
          @endforeach
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <x-button
            type="button"
            variant="secondary"
            size="sm"
            data-action="back-to-show"
            data-option-id="{{ $option->id }}">
            Cancel
          </x-button>

          <x-button type="submit" variant="primary" size="sm">Save</x-button>
        </div>
      </form>
    </div>
  </x-modal>

</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const showModal = document.getElementById('productOptionModal');
    const contentContainer = showModal.querySelector(`#${showModal.id}-content`);

    // Fonction pour afficher un template dans le modal
    const showTemplate = (templateId) => {
      const template = document.getElementById(templateId);
      if (!template) return;
      contentContainer.innerHTML = template.innerHTML;

      attachEditButtons();
      attachBackButtons();
      attachAddValueBtn(); // <-- On attache le bouton addValue après injection
    };

    // Edit buttons
    const attachEditButtons = () => {
      contentContainer.querySelectorAll('.edit-option-btn').forEach(editBtn => {
        editBtn.addEventListener('click', () => {
          const optionId = editBtn.dataset.optionId;
          showTemplate(`option-edit-template-${optionId}`);
        });
      });
    };

    // Cancel/back buttons
    const attachBackButtons = () => {
      contentContainer.querySelectorAll('[data-action="back-to-show"]').forEach(btn => {
        btn.addEventListener('click', () => {
          const optionId = btn.dataset.optionId;
          showTemplate(`option-template-${optionId}`);
        });
      });
    };

    // Add Value Button
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

        // removeValue
        div.querySelector('.removeValue').addEventListener('click', () => {
          div.remove();
        });
      });
    };

    // Ouvrir le modal show initial
    document.querySelectorAll('[data-modal-content-id]').forEach(btn => {
      btn.addEventListener('click', () => {
        const templateId = btn.dataset.modalContentId;
        showTemplate(templateId);
        showModal.classList.remove('hidden');
        showModal.classList.add('flex');
      });
    });

    // Manage options modal
    const manageModal = document.getElementById('manageOptionsModal');
    document.getElementById('manageOptionsBtn').addEventListener('click', () => {
      manageModal.classList.remove('hidden');
      manageModal.classList.add('flex');
    });

    // Click en dehors du modal pour fermer
    [showModal, manageModal].forEach(modal => {
      modal.addEventListener('click', e => {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    });

    // Escape pour fermer modals
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