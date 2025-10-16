@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Options')

@section('content')

<div class="flex items-center justify-between mb-8">
  <h2 class="text-3xl font-bold text-white">Product Options</h2>

  <x-button :href="route('dashboard.products-options.create')" variant="primary" size="sm">
    + Add Option
  </x-button>
</div>

<div class="flex items-center mb-3 gap-3">
  <div class="flex-1">
    <x-search-bar route="dashboard.products-options.index" placeholder="Search in options..." name="s" />
  </div>
  <div class="w-2/3">
    <x-product-options-filter-bar
      :route="$route"
      :products="$products"
      :currentProduct="$currentProduct"
      :types="$types"
      :currentType="$currentType" />
  </div>
</div>

<div class="overflow-x-auto bg-gray-800/50 rounded-lg shadow-lg">
  <x-table
    :headers="[
            ['label' => 'Name', 'sortable' => true, 'column' => 'name'],
            ['label' => 'Type', 'sortable' => true, 'column' => 'type'],
            ['label' => 'Default Value'],
            ['label' => 'Default Price', 'sortable' => true, 'column' => 'default_price'],
            ['label' => 'Product', 'sortable' => true, 'column' => 'product_id'],
            ['label' => 'Actions'],
        ]"
    route="dashboard.products-options.index"
    :rowsCount="$productOptions->count()">

    @foreach ($productOptions as $option)

    @php
    $defaultPivot = $option->products->first()?->pivot;
    if (in_array($option->type, ['text', 'number'])) {
    $defaultValue = $option->products->first()?->pivot->default_value ?? '—';
    $defaultPrice = $option->products->first()?->pivot->default_price ?? 0;
    } else {
    $defaultValObj = $option->values->firstWhere('is_default', true);
    $defaultValue = $defaultValObj->value ?? '—';
    $defaultPrice = $defaultValObj->price ?? 0;
    }
    @endphp

    <tr class="hover:bg-gray-700/40 transition-colors group">
      <td class="px-6 py-3 text-gray-200 font-medium">{{ $option->name }}</td>
      <td class="px-6 py-3 text-gray-300 capitalize">{{ ucfirst(str_replace('_', ' ', $option->type)) }}</td>
      <td class="px-6 py-3 text-gray-300">{{ $defaultValue }}</td>
      <td class="px-6 py-3 text-gray-300">{{ number_format($defaultPrice, 2) }} €</td>

      <td class="px-6 py-3 text-gray-300">
        {{ $option->products->pluck('name')->join(', ') ?: '—' }}
      </td>

      <td class="px-6 py-3 flex items-center gap-1">
        <x-button :href="route('dashboard.products-options.show', $option->id)" variant="ghost" size="sm">
          <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-button :href="route('dashboard.products-options.edit', $option->id)" variant="ghost" size="sm">
          <x-heroicon-o-pencil-square class="size-5 text-blue-400 hover:text-blue-500 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-confirmation-delete-dialog
          :modelId="$option->id"
          modelName="productOption"
          route="dashboard.products-options.delete"
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