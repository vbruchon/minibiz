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

<div class="flex items-center justify-between mb-8">
  <h2 class="text-3xl font-bold text-white">Customers</h2>

  <x-button :href="route('customers.create')" variant="primary" size="sm">
    + Add Customer
  </x-button>

</div>
<div class="flex items-center mb-3">
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
        <span class="block w-24 text-center px-3 py-1.5 text-sm rounded-md {{ 
    strtolower(trim($customer->status ?? '')) === 'active' 
        ? 'bg-green-600/20 text-green-400 border border-green-500/30' 
        : (strtolower(trim($customer->status ?? '')) === 'inactive' 
            ? 'bg-gray-600/20 text-gray-400 border border-gray-500/30' 
            : 'bg-yellow-600/20 text-yellow-400 border border-yellow-500/30') 
}}">
          {{ ucfirst(strtolower(trim($customer->status ?? ''))) ?: '—' }}
        </span>
      </td>
      <td class="px-6 py-3 flex items-center">
        <x-button :href="route('customers.show', $customer->id)" variant="ghost" size="sm">
          <x-heroicon-o-eye class="size-5 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-button :href="route('customers.edit', $customer->id)" variant="ghost" size="sm">
          <x-heroicon-o-pencil-square class="size-5 text-blue-400 hover:text-blue-500 transition opacity-0 group-hover:opacity-100" />
        </x-button>

        <x-confirmation-delete-dialog customerId="{{ $customer->id }}" variant="ghost">
          <x-heroicon-o-trash class="size-5 text-destructive mt-1 hover:text-destructive/70 hover:cursor-pointer transition opacity-0 group-hover:opacity-100" />

        </x-confirmation-delete-dialog>

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