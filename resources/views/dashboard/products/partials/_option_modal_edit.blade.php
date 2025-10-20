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