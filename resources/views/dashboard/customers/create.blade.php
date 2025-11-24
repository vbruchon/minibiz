@extends('layouts.dashboard')

@section('title', 'MiniBiz - Ajouter client')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="Ajouter un client" />
    <x-customer-form />
  </div>
</div>
@endsection