@extends('layouts.dashboard')

@section('title', 'MiniBiz - Customers')

@section('content')

<x-header
  title="Clients">
  <x-slot name="actions">
    <x-button :href="route('dashboard.customers.create')" variant="primary" size="sm">
      + Ajouter Client
    </x-button>
  </x-slot>
</x-header>

<div class="w-1/3">
  <x-list-controls
    route="dashboard.customers.index"
    searchPlaceholder="Rechercher dans les clients..."
    searchName="s"
    :filters="[
        [
            'name' => 'status',   
            'label' => 'Status',
            'options' => [
                'active' => 'Actif',
                'prospect' => 'Prospect',
                'inactive' => 'Inactif',
            ],
        ]
    ]" />
</div>

<div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
  <x-table
    :headers="[
      ['label' => 'Entreprise', 'sortable' => true, 'column' => 'company_name'],
      ['label' => 'Email', 'sortable' => true, 'column' => 'company_email'],
      ['label' => 'Téléphone'],
      ['label' => 'Ville', 'sortable' => true, 'column' => 'city'],
      ['label' => 'Status'],
      ['label' => 'Actions'],
    ]"
    route="dashboard.customers.index"
    :rowsCount="$customers->count()">

    @foreach ($customers as $customer)
    <tr class="hover:bg-muted/10 transition-colors group">
      <td class="px-6 py-3 text-foreground font-medium">
        {{ $customer->company_name }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $customer->company_email }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $customer->company_phone ?: '—' }}
      </td>

      <td class="px-6 py-3 text-muted-foreground">
        {{ $customer->city }}
      </td>

      <td class="px-6 py-3">
        <x-customer.status-badge :status="$customer->status" />
      </td>


      <td class="px-6 py-3 flex items-center gap-1">
        <x-tooltip-button label="Voir">
          <x-button :href="route('dashboard.customers.show', $customer->id)" variant="ghost" size="sm">
            <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
          </x-button>
        </x-tooltip-button>

        <x-tooltip-button label="Modifier">
          <x-button :href="route('dashboard.customers.edit', $customer->id)" variant="ghost" size="sm">
            <x-heroicon-o-pencil-square class="size-5 text-primary transition opacity-0 group-hover:opacity-100" />
          </x-button>
        </x-tooltip-button>

        <x-tooltip-button label="Supprimer">
          <x-confirmation-delete-dialog
            :modelId="$customer->id"
            modelName="customer"
            route="dashboard.customers.delete"
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
  {{ $customers->links() }}
</div>
@endsection