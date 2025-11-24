@extends('layouts.dashboard')

@section('title', 'MiniBiz - Ajouter une option produit')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Ajouter une option à un produit" />

    <x-card>
      <x-product-options-form :products="$products" />
    </x-card>
  </div>
</div>
@endsection