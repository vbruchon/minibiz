@extends('layouts.dashboard')

@section('title', 'Edit Product Options')

@section('content')
<div>
  <x-back-button />

  <div class=" mx-auto mt-2 p-8">
    <h1 class="text-3xl font-bold text-foreground mb-8">Edit Product Options</h1>

    <x-product-options-form
      :action="route('dashboard.products-options.update', $productOption->id)"
      method="PUT"
      :products="$products"
      :option="$productOption" />

  </div>
</div>
@endsection