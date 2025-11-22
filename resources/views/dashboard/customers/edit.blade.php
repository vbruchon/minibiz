@extends('layouts.dashboard')

@section('title', 'MiniBiz - Modifier client')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mx-auto mt-4 p-8 space-y-8">
    <h1 class="text-3xl font-bold text-foreground">
      Modifier le client
    </h1>

    <div class="bg-card border border-border rounded-xl shadow-sm p-4">
      <x-customer-form
        :action="route('dashboard.customers.update', $customer->id)"
        method="PUT"
        :customer="$customer" />
    </div>
  </div>
</div>
@endsection