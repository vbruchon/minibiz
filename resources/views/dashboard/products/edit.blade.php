@extends('layouts.dashboard')

@section('title', 'MiniBiz - Edit Product')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Modifier {{$product->name}}" />
    <x-product-form
      :action="route('dashboard.products.update', $product->id)"
      method="PUT"
      :product="$product" />
  </div>
</div>
@endsection