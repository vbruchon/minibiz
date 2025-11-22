@extends('layouts.dashboard')

@section('title', 'Edit Product Options')

@section('content')
<div>
  <x-back-button />

  <div class=" mx-auto mt-4 p-8 space-y-8">
    <h1 class="text-3xl font-bold text-foreground">
      Modifier une option produit
    </h1>
    <div class="bg-card border border-border rounded-xl shadow-sm p-6">
      <x-product-options-form
        :action="route('dashboard.products-options.update', $productOption->id)"
        method="PUT"
        :products="$products"
        :option="$productOption" />
    </div>
  </div>
</div>
@endsection