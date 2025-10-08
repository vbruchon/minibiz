@extends('layouts.dashboard')

@section('title', 'MiniBiz - Customers')

@section('content')
<div class="flex items-center justify-between mb-8">
  <h2 class="text-3xl font-bold text-white">Customers</h2>

  <a href="{{ route('customers.create') }}"
    class="inline-block bg-primary hover:bg-primary/90 transition-colors py-2.5 px-5 rounded-lg font-semibold shadow">
    + Add Customer
  </a>
</div>

<x-search-bar route="customers.index" placeholder="Search in customers..." name="s" />

<div class="overflow-x-auto bg-gray-800/50 rounded-lg shadow-lg">
  <table class="min-w-full divide-y divide-gray-700">
    <thead class="bg-gray-900">
      <tr>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
          <div class="flex items-center gap-4">
            <span>Name</span>
            <x-sort-arrows column="name" route="customers.index" />
          </div>
        </th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">
          <div class="flex items-center gap-4">
            <span>Email</span>
            <x-sort-arrows column="email" route="customers.index" />
          </div>
        </th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Phone</th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Address</th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>
    <tbody class="bg-gray-900/60 divide-y divide-gray-700">
      @forelse($customers as $customer)
      <tr class="hover:bg-gray-700/40 transition-colors group">
        <td class="px-6 py-4 text-gray-200 font-medium">{{ $customer->name }}</td>
        <td class="px-6 py-4 text-gray-300">{{ $customer->email }}</td>
        <td class="px-6 py-4 text-gray-300">{{ $customer->phone }}</td>
        <td class="px-6 py-4 text-gray-300">{{ $customer->address }}</td>

        <td class="px-6 py-4 flex items-center gap-3">
          <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-400 hover:text-blue-500 transition opacity-0 group-hover:opacity-100">
            <x-heroicon-o-pencil-square class="size-5" />
          </a>
          <form action="{{ route('customers.delete', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-destructive mt-1 hover:text-destructive/70 hover:cursor-pointer transition opacity-0 group-hover:opacity-100">
              <x-heroicon-o-trash class="size-5" />
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="px-6 py-4 text-center text-gray-400">
          No data found
        </td>
      </tr>
      @endforelse
    </tbody>

  </table>
</div>

<div class="mt-6">
  {{ $customers->links() }}
</div>

@if(session('success'))
<x-toast type="success" :message="session('success')" />
@endif

@if(session('error'))
<x-toast type="error" :message="session('error')" />
@endif
@endsection