@extends('layouts.dashboard')

@section('title', 'MiniBiz - Détails du devis')

@section('content')
<div class="mx-auto">
  {{-- Bouton retour + actions --}}
  <div class="flex items-center justify-between mt-2 mb-6">
    <x-back-button />

    <div class="flex items-center gap-3">
      @if($bill->canBeConverted())
      <x-button
        data-modal-target="convert-modal"
        variant="warning"
        size="sm"
        class="gap-2 py-0.5 w-fit">
        <x-heroicon-o-document-arrow-down class="size-5" />
        Convertir en facture
      </x-button>
      @endif

      @if($bill->canBeEdited())
      <x-button :href="route('dashboard.bills.edit', $bill->id)" variant="info" size="sm" class="gap-2 py-0.5 w-fit">
        <x-heroicon-o-pencil-square class="size-5" />
        Modifier
      </x-button>

      <x-confirmation-delete-dialog
        :modelId="$bill->id"
        modelName="bill"
        route="dashboard.bills.delete"
        variant="destructive"
        customClass="flex items-center gap-2 py-0.5">
        <x-heroicon-o-trash class="size-5" />
        <span>Supprimer</span>
      </x-confirmation-delete-dialog>
      @endif

    </div>
  </div>

  @if($bill->isQuote() && $bill->convertedInvoice)
  @include('dashboard.bills.partials.show._converted_banner')
  @endif

  <div class="flex flex-col gap-8 bg-white shadow-md rounded-lg p-10 border border-gray-200 mx-auto my-6 w-[210mm] min-h-[297mm] text-gray-800 print:shadow-none print:border-none print:p-0">
    @include('dashboard.bills.partials.show._header', ['bill' => $bill, 'type' => $type])
    @include('dashboard.bills.partials.show._entities', $bill)
    @include('dashboard.bills.partials.show._products_table', ['bill' => $bill, 'optionsHeader' => $optionsHeader])
    @include('dashboard.bills.partials.show._totals', $bill)

    @if($bill->isQuote())
    @include('dashboard.bills.partials.show._quote_conditions', $bill)
    @elseif($bill->isInvoice())
    @include('dashboard.bills.partials.show._invoice_conditions', $bill)
    @endif

    @if($bill->footer_note || $bill->notes)
    <div class="text-sm">
      <h4 class="font-semibold mb-2">Notes</h4>
      <p class="whitespace-pre-line">{{ $bill->footer_note }}</p>
      <p class="whitespace-pre-line">{{ $bill->notes }}</p>
    </div>
    @endif

  </div>
</div>

@include('dashboard.bills.partials.show._convert_modal', $paymentLabels)

@endsection