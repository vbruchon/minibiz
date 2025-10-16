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

    {{-- Linked Options --}}
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
            @php
            $defaultValObj = $option->values->firstWhere('is_default', true);
            if(in_array($option->type, ['text', 'number'])){
            $defaultValue = $option->pivot->default_value ?? '-';
            $defaultPrice = $option->pivot->default_price ?? 0;
            } else {
            $defaultValue = $defaultValObj->value ?? '-';
            $defaultPrice = $defaultValObj->price ?? 0;
            }
            @endphp
            <tr>
              <td class="px-4 py-2 text-gray-100">{{ $option->name }}</td>
              <td class="px-4 py-2 text-gray-300">{{ ucfirst($option->type) }}</td>
              <td class="px-4 py-2 text-gray-300">{{ $defaultValue }}</td>
              <td class="px-4 py-2 text-gray-300">{{ number_format($defaultPrice, 2) }}</td>
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
        <x-button href="{{ route('dashboard.products-options.edit', $option->id) }}" variant="info" size="sm">Edit</x-button>
      </div>
    </div>
  </template>
  @endforeach

  {{-- Show Option Modal --}}
  <x-modal id="productOptionModal"></x-modal>

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
          <x-button type="button" variant="secondary" size="sm" data-modal-target="manageOptionsModal">
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
    // ===== Show Option Modal (dynamic content) =====
    const showModal = document.getElementById('productOptionModal');

    document.querySelectorAll('[data-modal-content-id]').forEach(btn => {
      btn.addEventListener('click', () => {
        const templateId = btn.dataset.modalContentId;
        const template = document.getElementById(templateId);
        if (template) {
          showModal.querySelector(`#${showModal.id}-content`).innerHTML = template.innerHTML;
        }
        showModal.classList.remove('hidden');
        showModal.classList.add('flex');
      });
    });

    // ===== Manage Options Modal (static content) =====
    const manageModal = document.getElementById('manageOptionsModal');
    document.getElementById('manageOptionsBtn').addEventListener('click', () => {
      manageModal.classList.remove('hidden');
      manageModal.classList.add('flex');
    });

    // ===== Close modals on click outside or Escape =====
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