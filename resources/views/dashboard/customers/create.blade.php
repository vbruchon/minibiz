@extends('layouts.dashboard')

@section('title', 'Add customer')

@section('content')
<div>
  <x-button :href="route('customers.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" />
    Back
  </x-button>
  <div class=" mx-auto mt-2 p-8">
    <h1 class="text-3xl font-bold text-foreground mb-8">Add customer</h1>

    <x-customer-form />

  </div>
</div>
@endsection