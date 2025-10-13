@extends('layouts.dashboard')

@section('title', 'Edit customer')

@section('content')
<div>
  <x-button :href="route('dashboard.customers.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" />
    Back
  </x-button>

  <div class="mx-auto mt-2 p-8">
    <h2 class="text-5xl font-bold text-foreground mb-8">Edit customer</h2>

    <x-customer-form
      :action="route('dashboard.customers.update', $customer->id)"
      method="PUT"
      :customer="$customer" />

  </div>
</div>
@endsection