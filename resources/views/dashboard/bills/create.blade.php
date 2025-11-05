@extends('layouts.dashboard')

@section('title', 'Créer un devis')

@section('head')
<meta name="prices" content='@json($prices)'>
<meta name="options" content='@json($productOptions)'>
<meta name="has-vat" content='@json($hasVAT)'>
<meta name="vat-rate" content='@json($vatRate)'>
@endsection

@section('content')
<div class="mx-auto space-y-6">
  <div class="flex items-center justify-center gap-2 relative">
    <x-back-button class="absolute left-0" />
    <h1 class="text-3xl font-bold text-center">Créer un devis</h1>
  </div>

  <form id="bill-form" action="{{ route('dashboard.bills.store')}}" method="POST" class="mx-auto max-w-6xl space-y-10 bg-gradient-to-br from-gray-900/60 to-gray-800/60 
         rounded-2xl p-10 shadow-2xl backdrop-blur-md border border-white/10
         transition-all duration-300 hover:border-primary/30" id="quote-form">
    @csrf

    @include('dashboard.bills.partials.form._customer')
    @include('dashboard.bills.partials.form._products')
    @include('dashboard.bills.partials.form._info')
    @include('dashboard.bills.partials.form._summary')
    @include('dashboard.bills.partials.form._note')

    <div class="flex justify-end mt-6">
      <x-button type="submit" variant="primary" size="sm">Enregistrer le devis</x-button>
    </div>
  </form>
</div>

@include('dashboard.bills.partials.form._bill-line-template')
@include('dashboard.bills.partials.form._option-template')

@endsection

@vite(['resources/js/pages/bills/create.js'])