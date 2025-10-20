@extends('layouts.dashboard')

@section('title', 'MiniBiz - Edit product')

@section('content')
<div>
  <x-back-button />

  <div class="mx-auto mt-2 p-8">
    <h2 class="text-5xl font-bold text-foreground mb-8">Edit Product</h2>

    <x-product-form
      :action="route('dashboard.products.update', $product->id)"
      method="PUT"
      :product="$product" />

  </div>
</div>
@endsection