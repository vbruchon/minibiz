@extends('layouts.dashboard')

@section('title', 'MiniBiz - Customers')

@section('content')

@php
$statusClasses = [
'active' => 'border border-primary px-2 py-1 rounded text-primary',
'inactive' => 'border border-muted px-2 py-1 rounded text-muted',
'prospect' => ' border border-warning px-2 py-1 rounded text-warning',
];
@endphp

<div class="flex items-center justify-between mb-6">
  <h2 class="text-3xl font-bold text-white">Customers</h2>

  <x-button :href="route('customers.create')" variant="primary" size="sm">
    + Add Customer
  </x-button>

</div>
<div class="flex items-center">
  <div class="flex-1">
    <x-search-bar route="customers.index" placeholder="Search in customers..." name="s" />
  </div>
  <div class="flex-2">
    <x-filter-bar />
  </div>
</div>



<div class="overflow-x-auto bg-gray-800/50 rounded-lg shadow-lg">

  <x-table
    :headers="[
        ['label' => 'Company', 'sortable' => true, 'column' => 'company_name'],
        ['label' => 'Email', 'sortable' => true, 'column' => 'company_email'],
        ['label' => 'Phone'],
        ['label' => 'City', 'sortable' => true, 'column' => 'city'],
        ['label' => 'Status'],
        ['label' => 'Actions'],
    ]"
    route="customers.index">
    @foreach ($customers as $customer)
    <tr class="hover:bg-gray-700/40 transition-colors group">
      <td class="px-6 py-3 text-gray-200 font-medium">{{ $customer->company_name }}</td>
      <td class="px-6 py-3 text-gray-300">{{ $customer->company_email }}</td>
      <td class="px-6 py-3 text-gray-300">{{ $customer->company_phone }}</td>
      <td class="px-6 py-3 text-gray-300">{{ $customer->city }}</td>
      <td class="px-6 py-3">
        <span class="{{ $statusClasses[$customer->status] ?? 'bg-gray-100 text-gray-700 border border-gray-300' }} 
                    inline-block text-sm text-center px-1 py-0.5 rounded-lg min-w-[80px]">
          {{ ucfirst($customer->status) }}
        </span>
      </td>
      <td class="px-6 py-3 flex items-center">
        <x-button :href="route('customers.show', $customer->id)" variant="ghost" size="sm">
          <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-button :href="route('customers.edit', $customer->id)" variant="ghost" size="sm">
          <x-heroicon-o-pencil-square class="size-5 text-blue-400 hover:text-blue-500 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-confirmation-delete-dialog customerId="{{ $customer->id }}" />

      </td>
    </tr>
    @endforeach
  </x-table>
</div>

<div class="mt-4">
  {{ $customers->links() }}
</div>

@if(session('success'))
<x-toast type="success" :message="session('success')" />
@endif

@if(session('error'))
<x-toast type="error" :message="session('error')" />
@endif
@endsection