@extends('layouts.dashboard')

@section('title', 'MiniBiz - ' . $bill->isInvoice() ? 'Modifier une facture' : 'Modifier un devis')

@section('head')
@include('dashboard.bills.partials.form._meta')
@endsection

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mt-8 space-y-6">
    <x-header title="{{ $type === 'invoice' ? 'Modifier une facture' : 'Modifier un devis' }}" />
    @include('dashboard.bills.partials.form._form', [
    'formAction' => route('dashboard.bills.update', $bill),
    'submitLabel' => $bill->isInvoice()'
    ? 'Mettre à jour la facture'
    : 'Mettre à jour le devis',
    'bill' => $bill,
    'type' => $bill->type,
    ])
  </div>
</div>
@endsection