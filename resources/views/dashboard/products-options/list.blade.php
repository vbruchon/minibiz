@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Options')

@section('content')

<div class="flex items-center justify-between mb-8">
  <h1 class="text-3xl font-bold text-foreground">
    Product Options
  </h1>

  <x-button :href="route('dashboard.products-options.create')" variant="primary" size="sm">
    + Add Option
  </x-button>
</div>

<div class="flex items-center gap-6 w-2/3 mb-3">
  <div class="flex-1">
    <x-search-bar
      route="dashboard.products-options.index"
      placeholder="Search in options..."
      name="s" />
  </div>

  <div class="w-fit">
    <x-product-options-filter-bar
      :route="$route"
      :products="$products"
      :currentProduct="$currentProduct"
      :types="$types"
      :currentType="$currentType" />
  </div>
</div>

<div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
  <x-table
    :headers="[
      ['label' => 'Name', 'sortable' => true, 'column' => 'name'],
      ['label' => 'Type', 'sortable' => true, 'column' => 'type'],
      ['label' => 'Default Value'],
      ['label' => 'Default Price', 'sortable' => true, 'column' => 'default_price'],
      ['label' => 'Products', 'sortable' => true, 'column' => 'product_id'],
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