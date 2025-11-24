@extends('layouts.dashboard')

@section('title', 'MiniBiz - Ajouter un produit')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Ajouter un produit" />
    <x-product-form />
  </div>
</div>
@endsection