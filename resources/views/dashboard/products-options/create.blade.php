@extends('layouts.dashboard')

@section('title', 'MiniBiz - Ajouter une option produit')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mx-auto mt-4 p-8 space-y-8">
    <h1 class="text-3xl font-bold text-foreground">
      Ajouter une option produit
    </h1>

    <div class="bg-card border border-border rounded-xl shadow-sm p-6">
      <x-product-options-form :products="$products" />
    </div>
  </div>
</div>
@endsection