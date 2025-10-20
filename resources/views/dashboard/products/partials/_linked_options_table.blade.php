  <x-show-info title="Linked Options">

    {{-- Table des options liées --}}
    <div class="overflow-x-auto">
      <x-table
        :headers="[
          ['label' => 'Option Name'],
          ['label' => 'Type'],
          ['label' => 'Default Value'],
          ['label' => 'Default Price (€)'],
          ['label' => 'Actions']
        ]"
        :rows-count="$productOptions->count()"
        empty="No options linked to this product yet.">
        @foreach ($productOptions as $option)
        <tr>
          <td class="px-6 py-3 text-gray-100">{{ $option->name }}</td>
          <td class="px-6 py-3 text-gray-300">{{ ucfirst($option->type) }}</td>
          <td class="px-6 py-3 text-gray-300">{{ $option->default_value }}</td>
          <td class="px-6 py-3 text-gray-300">{{ number_format($option->default_price, 2) }}</td>
          <td class="px-6 py-3 text-right">
            <button
              type="button"
              data-modal-target="productOptionModal"
              data-modal-content-id="option-template-{{ $option->id }}"
              class="text-gray-400 hover:text-gray-200">
              <x-heroicon-o-eye class="size-4 cursor-pointer" />
            </button>
          </td>
        </tr>
        @endforeach
      </x-table>
    </div>

    {{-- Manage Options Button --}}

    <div class="mt-4 flex items-center justify-between">
      <x-button
        type="button"
        variant="outline"
        size="sm"
        id="manageOptionsBtn"
        class="!text-gray-400">
        <x-heroicon-o-cog class="size-6" /> Manage Options
      </x-button>

      {{ $productOptions->links() }}
    </div>

  </x-show-info>