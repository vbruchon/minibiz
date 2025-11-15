@extends('layouts.dashboard')

@section('title', 'MiniBiz - ' . $bill->type === 'invoice' ? 'Modifier une facture' : 'Modifier un devis')

@section('head')
@include('dashboard.bills.partials.form._meta')
@endsection

@section('content')
<div class="mx-auto space-y-6">
  <div class="flex items-center justify-center gap-2 relative">
    <x-back-button class="absolute left-0" />

    <h1 class="text-3xl font-bold text-center">
      {{ $bill->type === 'invoice' ? 'Modifier une facture' : 'Modifier un devis' }}
    </h1>
  </div>

  @include('dashboard.bills.partials.form._form', [
  'formAction' => route('dashboard.bills.update', $bill),
  'submitLabel' => $bill->type === 'invoice'
  ? 'Mettre à jour la facture'
  : 'Mettre à jour le devis',
  'bill' => $bill,
  'type' => $bill->type,
  ])
</div>
@endsection