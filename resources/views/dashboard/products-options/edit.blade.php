@extends('layouts.dashboard')

@section('title', 'Edit Product Options')

@section('content')
<div>
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Modifier {{$productOption->name}}" />
    <x-product-options-form
      :action="route('dashboard.products-options.update', $productOption->id)"
      method="PUT"
      :products="$products"
      :option="$productOption" />
  </div>
</div>
</div>
@endsection