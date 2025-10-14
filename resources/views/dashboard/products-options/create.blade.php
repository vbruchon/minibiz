@extends('layouts.dashboard')

@section('title', 'Add Product Options')

@section('content')
<div>
  <x-button :href="route('dashboard.products-options.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" />
    Back
  </x-button>
  <div class=" mx-auto mt-2 p-8">
    <h1 class="text-3xl font-bold text-foreground mb-8">Add Product Options</h1>

    <x-product-options-form :products="$products" />

  </div>
</div>
@endsection