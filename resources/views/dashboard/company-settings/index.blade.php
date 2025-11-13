@extends('layouts.dashboard')

@section('title', 'MiniBiz - Configuration de l’entreprise')

@section('content')
<div class="mx-auto">
  <h1 class="text-3xl text-center font-bold text-foreground mb-6">Configuration de l’entreprise</h1>
  <div>
    <form
      method="POST"
      action="{{ route('dashboard.company-settings.save') }}"
      enctype="multipart/form-data"
      class="mx-auto max-w-6xl space-y-10 bg-gradient-to-br from-gray-900/60 to-gray-800/60 
         rounded-2xl p-10 shadow-2xl backdrop-blur-md border border-white/10
         transition-all duration-300 hover:border-primary/30">
      @csrf

      <p class="text-gray-300 text-center italic mb-8">
        Veuillez renseigner les informations de votre entreprise. Ces données apparaîtront automatiquement sur vos devis et factures.
      </p>

      @include('dashboard.company-settings.partials/_visual_identity', ['company' => $company])
      @include('dashboard.company-settings.partials._company_info', ['company' => $company])
      @include('dashboard.company-settings.partials._legal_info', [
      'company' => $company,
      'initialType' => $initialType
      ])
      @include('dashboard.company-settings.partials._payment_settings', ['company' => $company])

      <div class="flex justify-end pt-4">
        <x-button type="submit" variant="primary" size="md">
          Sauvegarder la configuration
        </x-button>
      </div>
    </form>
  </div>
</div>
@endsection

@vite('resources/js/pages/company-settings.js')