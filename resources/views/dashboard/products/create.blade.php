@extends('layouts.dashboard')

@section('title', 'Add Product')

@section('content')
<div>
  <x-button :href="route('dashboard.products.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" />
    Back
  </x-button>
  <div class=" mx-auto mt-2 p-8">
    <h1 class="text-3xl font-bold text-foreground mb-8">Add Product</h1>

    <x-product-form />

  </div>
</div>
@endsection