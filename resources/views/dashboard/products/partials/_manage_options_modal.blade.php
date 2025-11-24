<x-modal id="manageOptionsModal">
  <div class="p-6 space-y-6 text-foreground">
    <h2 class="text-xl font-bold">Gérer les options du produits</h2>

    <form method="POST" action="{{ route('dashboard.products-options.sync', $product->id) }}">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
        @foreach($allOptions as $option)
        <label class="flex items-center gap-2 text-sm">
          <input
            type="checkbox"
            name="options[]"
            value="{{ $option->id }}"
            class="w-4 h-4 rounded border-border bg-input text-primary focus:ring-primary"
            {{ $product->options->contains($option) ? 'checked' : '' }}>

          {{ $option->name }} <span class="opacity-60">({{ ucfirst($option->type) }})</span>
        </label>
        @endforeach
      </div>

      <div class="flex justify-end gap-2 mt-8">
        <x-button type="button" variant="secondary" size="sm" data-modal-close>
          Retour
        </x-button>

        <x-button type="submit" variant="primary" size="sm">
          Sauvegarder
        </x-button>
      </div>
    </form>
  </div>
</x-modal>