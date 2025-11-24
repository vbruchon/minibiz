<x-show-info title="Options liée(s)">
  <div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
    <x-table
      :headers="[
          ['label' => 'Nom de l’option'],
          ['label' => 'Type'],
          ['label' => 'Valeur par défaut'],
          ['label' => 'Prix par défaut (€)'],
          ['label' => 'Actions'],
      ]"
      :rowsCount="$productOptions->count()"
      empty="Aucune option n’est encore liée à ce produit.">

      @foreach ($productOptions as $option)
      <tr class="hover:bg-muted/10 transition-colors group">
        <td class="px-6 py-3 text-foreground">{{ $option->name }}</td>
        <td class="px-6 py-3 text-muted-foreground">{{ ucfirst($option->type) }}</td>
        <td class="px-6 py-3 text-muted-foreground">{{ $option->default_value }}</td>
        <td class="px-6 py-3 text-muted-foreground">{{ number_format($option->default_price, 2) }}</td>

        <td class="px-6 py-3 text-right">
          <x-tooltip-button label="Voir">
            <x-button
              variant="ghost"
              size="sm"
              class="text-muted-foreground"
              data-modal-target="optionShowModal-{{ $option->id }}">
              <x-heroicon-o-eye class="size-5 opacity-0 group-hover:opacity-100 transition" />
            </x-button>
          </x-tooltip-button>
        </td>
      </tr>
      @endforeach
    </x-table>
  </div>

  <div class="mt-4 flex items-center justify-between">
    <div class="flex gap-2">
      <x-button
        type="button"
        variant="outline"
        size="sm"
        data-modal-target="manageOptionsModal">
        <x-heroicon-o-cog class="size-5" />
        Gérer les Options
      </x-button>

      <x-button
        type="button"
        variant="ghost"
        size="sm"
        class="!text-primary hover:!text-primary/70"
        data-modal-target="addOptionModal">
        + Ajouter une Option
      </x-button>
    </div>

    {{ $productOptions->links() }}
  </div>
</x-show-info>