@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Options')

@section('content')
<x-header
  title="Options Produits">
  <x-slot name="actions">
    <x-button :href="route('dashboard.products-options.create')" variant="primary" size="sm">
      + Créer une Option
    </x-button>
  </x-slot>
</x-header>

<div class="w-[40%]">
  <x-list-controls
    route="dashboard.products-options.index"
    searchPlaceholder="Rechercher dans les options..."
    searchName="s"
    :filters="[
        [
            'name' => 'product_id',
            'label' => 'Produit',
            'options' => $products,
        ],
        [
            'name' => 'type',
            'label' => 'Type',
            'options' => array_combine(
                $types->toArray(),
                collect($types)->map(fn($t) => ucfirst($t))->toArray()
            ),
        ],
    ]" />
</div>


<div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
  <x-table
    :headers="[
      ['label' => 'Nom', 'sortable' => true, 'column' => 'name'],
      ['label' => 'Type', 'sortable' => true, 'column' => 'type'],
      ['label' => 'Valeur par défault'],
      ['label' => 'Prix par défault', 'sortable' => true, 'column' => 'default_price'],
      ['label' => 'Produits', 'sortable' => true, 'column' => 'product_id'],
      ['label' => 'Actions'],
    ]"
    route="dashboard.products-options.index"
    :rowsCount="$productOptions->count()">

    @foreach ($productOptions as $option)
    <tr class="hover:bg-muted/10 transition-colors group">

      <td class="px-6 py-3 text-foreground font-medium">
        {{ $option->name }}
      </td>

      <td class="px-6 py-3 text-muted-foreground capitalize">
        {{ ucfirst(str_replace('_', ' ', $option->type)) }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $option->default_value ?: '—' }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $option->default_price !== null ? number_format($option->default_price, 2) . ' €' : '—' }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $option->products->pluck('name')->join(', ') ?: '—' }}
      </td>

      <td class="px-6 py-3 flex items-center gap-1">

        <x-tooltip-button label="Voir">
          <x-button :href="route('dashboard.products-options.show', $option->id)" variant="ghost" size="sm">
            <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
          </x-button>
        </x-tooltip-button>

        <x-tooltip-button label="Modifier">
          <x-button :href="route('dashboard.products-options.edit', $option->id)" variant="ghost" size="sm">
            <x-heroicon-o-pencil-square class="size-5 text-primary transition opacity-0 group-hover:opacity-100" />
          </x-button>
        </x-tooltip-button>

        <x-tooltip-button label="Supprimer">
          <x-confirmation-delete-dialog
            :modelId="$option->id"
            modelName="productOption"
            route="dashboard.products-options.delete"
            variant="ghost">
            <x-heroicon-o-trash class="size-5 text-destructive transition opacity-0 group-hover:opacity-100" />
          </x-confirmation-delete-dialog>
        </x-tooltip-button>

      </td>
    </tr>
    @endforeach
  </x-table>
</div>

<div class="mt-4">
  {{ $productOptions->links() }}
</div>

@endsection