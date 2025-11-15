@extends('layouts.dashboard')

@section('title', 'MiniBiz - ' . ($type === 'invoice' ? 'Créer une facture' : 'Créer un devis'))

@section('head')
@include('dashboard.bills.partials.form._meta')
@endsection

@section('content')
<div class="mx-auto space-y-6">
  <div class="flex items-center justify-center gap-2 relative">
    <x-back-button class="absolute left-0" />
    <h1 class="text-3xl font-bold text-center">
      {{ $type === 'invoice' ? 'Créer une facture' : 'Créer un devis' }}
    </h1>
  </div>

  @include('dashboard.bills.partials.form._form', [
  'formAction' => route('dashboard.bills.store', ['type' => $type]),
  'submitLabel' => $type === 'invoice' ? 'Créer la facture' : 'Enregistrer le devis',
  ])
</div>
@endsection