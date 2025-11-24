@extends('layouts.dashboard')

@section('title', 'Modifier Option Produit')

@section('content')
<div>
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Modifier {{$productOption->name}}" />

    <x-card>
      <x-product-options-form
        :action="route('dashboard.products-options.update', $productOption->id)"
        method="PUT"
        :products="$products"
        :option="$productOption" />
    </x-card>
  </div>
</div>
</div>
@endsection