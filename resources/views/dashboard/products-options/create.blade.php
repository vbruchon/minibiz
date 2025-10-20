@extends('layouts.dashboard')

@section('title', 'Add Product Options')

@section('content')
<div>
  <x-back-button />

  <div class=" mx-auto mt-2 p-8">
    <h1 class="text-3xl font-bold text-foreground mb-8">Add Product Options</h1>

    <x-product-options-form :products="$products" />

  </div>
</div>
@endsection