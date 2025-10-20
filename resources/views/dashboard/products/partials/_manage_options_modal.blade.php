<x-modal id="manageOptionsModal">
  <div class="p-6 space-y-4">
    <h2 class="text-xl font-bold py-4">Manage Product Options</h2>

    <form method="POST" action="{{ route('dashboard.products-options.sync', $product->id) }}">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
        @foreach($allOptions as $option)
        <label class="flex items-center gap-2">
          <input
            type="checkbox"
            name="options[]"
            value="{{ $option->id }}"
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
          data-action="back-to-show">
          Cancel
        </x-button>

        <x-button type="submit" variant="primary" size="sm">Save</x-button>
      </div>
    </form>
  </div>
</x-modal>