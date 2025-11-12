@extends('layouts.dashboard')

@section('title', 'MiniBiz - Détails du devis')

@section('content')
<div class="mx-auto">

  {{-- Bouton retour + actions --}}
  <div class="flex items-center justify-between mt-2 mb-6">
    <x-back-button />

    <div class="flex items-center gap-3">
      @if($bill->canBeEdited())
      <x-button :href="route('dashboard.bills.edit', $bill->id)" variant="info" size="sm" class="gap-2 py-0.5 w-22">
        <x-heroicon-o-pencil-square class="size-5" />
        Modifier
      </x-button>
      @endif
      <x-confirmation-delete-dialog
        :modelId="$bill->id"
        modelName="bill"
        route="dashboard.bills.delete"
        variant="destructive">
        <div class="flex items-center gap-2 py-0.5">
          <x-heroicon-o-trash class="size-5" />
          <span>Supprimer</span>
        </div>
      </x-confirmation-delete-dialog>
    </div>
  </div>

  {{-- Feuille A4 --}}
  <div class="flex flex-col gap-6 bg-white shadow-md rounded-lg p-10 border border-gray-200 mx-auto my-6 w-[210mm] min-h-[297mm] text-gray-800 print:shadow-none print:border-none print:p-0">

    {{-- Header  --}}
    <div class="flex justify-between">
      <div>
        <div class="flex items-center gap-3">
          <h2 class="text-2xl font-bold">
            Devis #{{ $bill->number }}
          </h2>
          <x-bill.status-badge :bill="$bill" isShow />
        </div>

        <div class="flex items-center gap-4 pt-1 text-sm text-gray-600 italic">
          <p>Émis le {{ $bill->issue_date->format('d/m/Y') }}</p>
          @if($bill->due_date)
          <span>-</span>
          <p>Valide jusqu’au {{ $bill->due_date->format('d/m/Y') }}</p>
          @endif
        </div>
      </div>

      @if($bill->company->logo_path)
      <img src="{{ $bill->company->logo_path }}" alt="Logo {{ $bill->company->company_name }}" class="size-12 ">
      @endif
    </div>

    <div class="flex items-start justify-between gap-20">
      <x-bill.entity-details
        :entity="$bill->company"
        title="Émetteur" />

      <x-bill.entity-details
        :entity="$bill->customer"
        title="Destinataire" />
    </div>

    <table class="w-full table-auto border-collapse text-[14px] leading-tight">
      <thead>
        <tr class="bg-gray-100 border-b border-gray-300 text-gray-700">
          <th class="text-left py-2 px-3 font-semibold w-fit">Produit</th>
          <th class="text-left py-2 px-3 font-semibold">{{$optionsHeader}}</th>
          <th class="text-right py-2 px-3 font-semibold w-fit whitespace-nowrap">Qté</th>
          <th class="text-right py-2 px-3 font-semibold w-fit whitespace-nowrap">PU HT</th>
          <th class="text-right py-2 px-3 font-semibold w-fit whitespace-nowrap">Total HT</th>
        </tr>
      </thead>

      <tbody>
        @foreach($bill->lines as $line)
        <tr class="border-b border-gray-200 text-gray-800 align-top">
          {{-- Produit --}}
          <td class="py-2 px-3 font-medium whitespace-nowrap">
            {{ $line->product->name }}
          </td>

          {{-- Options --}}
          <td class="py-2 px-3 text-sm">
            @if($line->selectedOptions->isNotEmpty())
            <ul class="space-y-1">
              @foreach($line->selectedOptions as $option)
              <li class="text-gray-700">
                <div class="flex flex-wrap">
                  {{-- Nom de l'option (ex: Maintenance annuelle :) --}}
                  <span class="font-medium shrink-0">
                    {{ $option->option?->name ?? 'Option' }} :
                  </span>

                  {{-- Valeur + prix, indentés automatiquement si retour à la ligne --}}
                  <span class="pl-2 flex-1 break-words">
                    {{ $option->value }}
                    @if($option->price > 0)
                    <span class="text-gray-500 text-xs">
                      (+{{ number_format($option->price, 2, ',', ' ') }} €)
                    </span>
                    @endif
                  </span>
                </div>
              </li>
              @endforeach
            </ul>
            @elseif($line->description)
            <div class="text-gray-700">{{ $line->description }}</div>
            @else
            <span class="text-gray-700 text-xs">—</span>
            @endif
          </td>


          {{-- Qté --}}
          <td class="text-right py-2 px-3 align-top w-fit whitespace-nowrap">
            {{ number_format($line->quantity, 2, ',', ' ') }}
          </td>

          {{-- PU HT --}}
          <td class="text-right py-2 px-3 align-top w-fit whitespace-nowrap">
            {{ number_format($line->unit_price, 2, ',', ' ') }} €
          </td>

          {{-- Total HT --}}
          <td class="text-right py-2 px-3 align-top font-semibold w-fit whitespace-nowrap">
            {{ number_format($line->total, 2, ',', ' ') }} €
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Totaux --}}
    <div class="space-y-2.5">
      @if($bill->company->footer_note)
      <p class="text-sm italic text-gray-500 text-right whitespace-pre-line">{{ $bill->company->footer_note }}</p>
      @endif
      <div class="flex justify-end">
        <div class="w-1/3 text-right space-y-1 text-sm">
          <div class="flex justify-between text-gray-600">
            <span>Sous-total :</span>
            <span>{{ number_format($bill->subtotal, 2, ',', ' ') }} €</span>
          </div>
          @if($bill->discount_percentage > 0)
          <div class="flex justify-between text-gray-600">
            <span>Remise ({{ $bill->discount_percentage }}%) :</span>
            <span>-{{ number_format($bill->discount_amount, 2, ',', ' ') }} €</span>
          </div>
          @endif
          <div class="flex justify-between font-semibold border-t border-gray-300 pt-2 mt-2">
            <span>Total TTC :</span>
            <span class="text-lg">{{ number_format($bill->total, 2, ',', ' ') }} €</span>
          </div>
        </div>
      </div>

    </div>

    {{-- Notes --}}
    @if($bill->footer_note)
    <div class="text-sm text-muted">
      <h4 class="font-semibold mb-2">Notes</h4>
      <p class="whitespace-pre-line">{{ $bill->footer_note }}</p>
    </div>
    @endif

    @if($bill->isQuote())
    <div>
      {{-- Conditions et mentions légales --}}
      <div class="grid grid-cols-2 text-sm text-gray-700 leading-relaxed gap-8">

        {{-- Conditions de règlement --}}
        <div class="space-y-0.5">
          <h4 class="text-lg font-medium mb-4">Conditions</h4>

          {{-- Conditions de règlement --}}
          <div class="flex items-center gap-4">
            <p class="font-semibold text-gray-900">Conditions de règlement :</p>
            <p>
              {{ $bill->payment_terms 
          ? ucfirst($bill->payment_terms)
          : 'Non spécifié' }}
            </p>
          </div>

          {{-- Intérêts de retard --}}
          <div class="flex items-center gap-4">
            <p class="font-semibold text-gray-900">Intérêts de retard :</p>
            <p>
              @if(is_numeric($bill->interest_rate))
              {{ rtrim(rtrim(number_format($bill->interest_rate, 2, '.', ''), '0'), '.') }}%
              @else
              {{ ucfirst($bill->interest_rate) }}
              @endif
            </p>
          </div>
        </div>


        {{-- Signature --}}
        <div class="space-y-0.5 justify-self-start">
          <h4 class="text-lg font-medium mb-4">Bon pour accord</h4>

          <p class="mt-2">À ............................................., le .... / .... / ........</p>

          <div class="mt-4 space-y-1">
            <p>Signature et cachet :</p>
            <div class="h-26 border border-dashed border-gray-400 rounded-md mt-2"></div>
            <p class="text-xs text-gray-500 mt-6">Qualité du signataire : .............................................,</p>
          </div>
        </div>

      </div>


    </div>
    @endif

  </div>
</div>
@endsection