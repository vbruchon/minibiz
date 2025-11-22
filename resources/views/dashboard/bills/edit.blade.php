@extends('layouts.dashboard')

@section('title', 'MiniBiz - ' . $bill->type === 'invoice' ? 'Modifier une facture' : 'Modifier un devis')

@section('head')
@include('dashboard.bills.partials.form._meta')
@endsection

@section('content')
<div class="mx-auto">
  <x-back-button />
  <div class="mx-auto p-8 space-y-6">
    <h1 class="text-3xl font-bold text-foreground">
      {{ $type === 'invoice' ? 'Créer une facture' : 'Créer un devis' }}
    </h1>

    <div class="bg-card border border-border rounded-xl shadow-sm p-6 mx-auto">
      @include('dashboard.bills.partials.form._form', [
      'formAction' => route('dashboard.bills.update', $bill),
      'submitLabel' => $bill->type === 'invoice'
      ? 'Mettre à jour la facture'
      : 'Mettre à jour le devis',
      'bill' => $bill,
      'type' => $bill->type,
      ])
    </div>
  </div>
</div>
@endsection