  <x-show-info title="Linked Options">
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
            <x-button
              type="button"
              variant="ghost"
              size="sm"
              data-modal-target="optionShowModal-{{ $option->id }}"
              class="text-gray-400 hover:text-gray-200">
              <x-heroicon-o-eye class="size-4 cursor-pointer" />
            </x-button>


          </td>
        </tr>
        @endforeach
      </x-table>
    </div>


    <div class="mt-4 flex items-center justify-between">
      <div class="flex gap-2 mt-4">
        <x-button
          type="button"
          variant="outline"
          size="sm"
          id="manageOptionsBtn"
          data-modal-target="manageOptionsModal">
          <x-heroicon-o-cog class="size-6" /> Manage Options
        </x-button>

        <x-button
          type="button"
          id="addOptionBtn"
          variant="ghost"
          size="sm"
          data-modal-target="addOptionModal"
          class="!text-blue-500 hover:!text-blue-700 !px-0">
          + Add Option
        </x-button>
      </div>


      {{ $productOptions->links() }}
    </div>

  </x-show-info>