@extends('layouts.dashboard')

@section('title', 'MiniBiz - Products')

@section('content')

@php
$statusClasses = [
'active' => 'bg-green-600/20 text-green-400 border border-green-500/30',
'inactive' => 'bg-gray-600/20 text-gray-400 border border-gray-500/30',
];
@endphp

<div class="flex items-center justify-between mb-8">
  <h2 class="text-3xl font-bold text-white">Products</h2>

  <x-button :href="route('dashboard.products.create')" variant="primary" size="sm">
    + Add Product
  </x-button>

</div>

<div class="flex items-center mb-3">
  <div class="flex-1">
    <x-search-bar route="dashboard.products.index" placeholder="Search in products..." name="s" />
  </div>
  <div class="flex-2">
    <x-filter-bar
      :route="route('dashboard.products.index')"
      :currentStatus="request('status')"
      :options="[
        'active' => 'Active',
        'inactive' => 'Inactive'
    ]" />
  </div>
</div>

<div class="overflow-x-auto bg-gray-800/50 rounded-lg shadow-lg">
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
    <tr class="hover:bg-gray-700/40 transition-colors group">
      <td class="px-6 py-3 text-gray-200 font-medium">{{ $product->name }}</td>
      <td class="px-6 py-3 text-gray-300 capitalize">
        {{ $product->type === 'time_unit' ? 'Time Unit' : 'Package' }}
      </td>
      <td class="px-6 py-3 text-gray-300">{{ $product->unit ?? '—' }}</td>
      <td class="px-6 py-3 text-gray-300">{{ number_format($product->base_price, 2) }} €</td>
      <td class="px-6 py-3">
        <span class="block w-24 text-center px-3 py-1.5 text-sm rounded-md {{ $statusClasses[$product->status] ?? '' }}">
          {{ ucfirst($product->status) }}
        </span>
      </td>
      <td class="px-6 py-3 flex items-center gap-1">
        <!-- show -->
        <x-button :href="route('dashboard.products.index')" variant="ghost" size="sm">
          <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <!-- edit -->
        <x-button :href="route('dashboard.products.index')" variant="ghost" size="sm">
          <x-heroicon-o-pencil-square class="size-5 text-blue-400 hover:text-blue-500 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <!-- settings options  -->
        <x-button :href="route('dashboard.products.index')" variant="ghost" size="sm">
          <x-heroicon-o-cog-6-tooth class="size-5 text-amber-400 hover:text-amber-500 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-confirmation-delete-dialog
          :modelId="$product->id"
          modelName="product"
          route="dashboard.products.index"
          variant="ghost">
          <x-heroicon-o-trash class="size-5 text-destructive mt-1 hover:text-destructive/70 hover:cursor-pointer transition opacity-0 group-hover:opacity-100" />
        </x-confirmation-delete-dialog>
      </td>
    </tr>
    @endforeach
  </x-table>
</div>


@if(session('success'))
<x-toast type="success" :message="session('success')" />
@endif

@if(session('error'))
<x-toast type="error" :message="session('error')" />
@endif
@endsection