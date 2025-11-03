@extends('layouts.dashboard')

@section('title', 'MiniBiz - Facturation')

@section('content')


<div class="mx-auto">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-foreground">Facturation</h1>

    <x-button :href="route('dashboard.bills.create')" variant="primary" size="sm" class="flex items-center gap-2">
      <x-heroicon-o-plus class="size-4" />
      Créer un devis
    </x-button>
  </div>

  <div class="flex items-center mb-3 gap-3">
    <div class="flex-1">
      <x-search-bar route="dashboard.bills.index" placeholder="Rechercher dans vos facture/devis..." name="s" />
    </div>
    <div class="w-2/3">
      <x-bills-filter-bar
        :route="route('dashboard.bills.index')"
        :types="['quote' => 'Quote', 'invoice' => 'Invoice']"
        :currentType="request('type')"
        :statuses="\App\Enums\BillStatus::cases()"
        :currentStatus="request('status')" />

    </div>
  </div>

  <x-table
    :headers="[
      ['label' => 'Number', 'sortable' => true, 'column' => 'number'],
      ['label' => 'Type', 'sortable' => true, 'column' => 'type'],
      ['label' => 'Status', 'sortable' => true, 'column' => 'status'],
      ['label' => 'Customer', 'sortable' => true, 'column' => 'customer_id'],
      ['label' => 'Total', 'sortable' => true, 'column' => 'total'],
      ['label' => 'Issue Date', 'sortable' => true, 'column' => 'issue_date'],
      ['label' => 'Actions'],
    ]"
    route="dashboard.bills.index"
    :rowsCount="$bills->count()">

    @foreach ($bills as $bill)
    @include('dashboard.bills.partials._rows', ['bill' => $bill])
    @endforeach
  </x-table>

  <div class="mt-4">
    {{ $bills->links() }}
  </div>

</div>
@endsection