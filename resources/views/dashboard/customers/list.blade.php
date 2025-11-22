@extends('layouts.dashboard')

@section('title', 'MiniBiz - Customers')

@section('content')

<div class="flex items-center justify-between mb-8">
  <h2 class="text-3xl font-bold text-foreground">Customers</h2>
  <x-button :href="route('dashboard.customers.create')" variant="primary" size="sm">
    + Add Customer
  </x-button>
</div>

<div class="flex items-center gap-6 w-1/3 mb-3">
  <div class="flex-1">
    <x-search-bar
      route="dashboard.customers.index"
      placeholder="Search in customers..."
      name="s" />
  </div>

  <div class="w-fit">
    <x-filter-bar
      :route="route('dashboard.customers.index')"
      :currentStatus="request('status')"
      :options="[
                'active' => 'Active',
                'prospect' => 'Prospect',
                'inactive' => 'Inactive'
            ]" />
  </div>
</div>


<div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
  <x-table
    :headers="[
      ['label' => 'Company', 'sortable' => true, 'column' => 'company_name'],
      ['label' => 'Email', 'sortable' => true, 'column' => 'company_email'],
      ['label' => 'Phone'],
      ['label' => 'City', 'sortable' => true, 'column' => 'city'],
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
        @php
        $status = strtolower(trim($customer->status ?? ''));
        $colors = [
        'active' => 'bg-success/15 text-success border-success/30',
        'inactive' => 'bg-muted/15 text-muted-foreground border-muted/40',
        'prospect' => 'bg-warning/15 text-warning border-warning/30',
        ];
        @endphp

        <span class="block w-24 text-center px-3 py-1.5 text-sm rounded-md border 
        {{ $colors[$status] ?? $colors['inactive'] }}">
          {{ ucfirst($status) ?: '—' }}
        </span>
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