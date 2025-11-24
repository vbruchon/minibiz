@extends('layouts.dashboard')

@section('title', 'MiniBiz - Modifier client')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Modifier {{$customer->company_name}}" />
    <x-customer-form
      :action="route('dashboard.customers.update', $customer->id)"
      method="PUT"
      :customer="$customer" />
  </div>
</div>
</div>
@endsection