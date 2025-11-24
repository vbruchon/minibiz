@extends('layouts.dashboard')

@section('title', 'MiniBiz - ' . ($type === 'invoice' ? 'Créer une facture' : 'Créer un devis'))

@section('head')
@include('dashboard.bills.partials.form._meta')
@endsection

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="{{ $type === 'invoice' ? 'Créer une facture' : 'Créer un devis' }}" />
    @include('dashboard.bills.partials.form._form', [
    'formAction' => route('dashboard.bills.store', ['type' => $type]),
    'submitLabel' => $type === 'invoice' ? 'Créer la facture' : 'Enregistrer le devis',
    ])
  </div>
</div>
@endsection