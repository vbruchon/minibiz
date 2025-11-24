@extends('layouts.dashboard')

@section('title', 'MiniBiz - Products')

@section('content')

<x-header
  title="Produits">
  <x-slot name="actions">
    <x-button :href="route('dashboard.products.create')" variant="primary" size="sm">
      + Ajouter Produit
    </x-button>
  </x-slot>
</x-header>

<div class="w-1/3">
  <x-list-controls
    route="dashboard.products.index"
    searchPlaceholder="Search in products..."
    searchName="s"
    :filters="[
        [
            'name' => 'status',
            'label' => 'Status',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ]
    ]" />
</div>

<div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
  <x-table
    :headers="[
            ['label' => 'Name', 'sortable' => true, 'column' => 'name'],
            ['label' => 'Type', 'sortable' => true, 'column' => 'type'],
            ['label' => 'Unit'],
            ['label' => 'Base Price', 'sortable' => true, 'column' => 'base_price'],
            ['label' => 'Status', 'sortable' => true, 'column' => 'status'],
            ['label' => 'Actions'],
        ]"
    route="dashboard.products.index"
    :rowsCount="$products->count()">

    @foreach ($products as $product)
    <tr class="hover:bg-muted/10 transition-colors group">
      <td class="px-6 py-3 text-foreground font-medium">
        {{ $product->name }}
      </td>

      <td class="px-6 py-3 text-muted-foreground capitalize">
        {{ $product->type === 'time_unit' ? 'Time Unit' : 'Package' }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $product->unit ?? '—' }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ number_format($product->base_price, 2) }} €
      </td>

      <td class="px-6 py-3">
        <x-product.status-badge :status="$product->status" />
      </td>

      <td class="px-6 py-3 flex items-center gap-1">
        <x-tooltip-button label="Voir">
          <x-button :href="route('dashboard.products.show', $product->id)" variant="ghost" size="sm">
            <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
          </x-button>
        </x-tooltip-button>

        <x-tooltip-button label="Modifier">
          <x-button :href="route('dashboard.products.edit', $product->id)" variant="ghost" size="sm">
            <x-heroicon-o-pencil-square class="size-5 text-primary transition opacity-0 group-hover:opacity-100" />
          </x-button>
        </x-tooltip-button>

        <x-tooltip-button label="Supprimer">
          <x-confirmation-delete-dialog
            :modelId="$product->id"
            modelName="product"
            route="dashboard.products.delete"
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
  {{ $products->links() }}
</div>

@endsection