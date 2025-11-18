@extends('layouts.dashboard')

@section('title', 'MiniBiz - Détail Client')

@section('content')
<div class="mx-auto">

  <x-back-button />

  <div class=" mx-auto mt-2 p-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Détail Client</h1>
    <div class="flex items-center gap-3">
      <x-button :href="route('dashboard.customers.edit', $customer->id)" variant="info" size="sm" class="gap-2 py-0.5 w-fit">
        <x-heroicon-o-pencil-square class="size-5" />
        Modifier
      </x-button>

      <x-confirmation-delete-dialog
        :modelId="$customer->id"
        modelName="customer"
        route="dashboard.customers.delete"
        variant="destructive">
        <div class="flex items-center gap-2 py-0.5">
          <x-heroicon-o-trash class="size-5" />
          <span>Supprimer</span>
        </div>
      </x-confirmation-delete-dialog>


    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 space-y-8">
      <x-show-info title="Company Info" :status="$customer->status">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <x-detail-field label="Company Name" :value="$customer->company_name" />
          <x-detail-field label="Email" :value="$customer->company_email" />
          <x-detail-field label="Phone" :value="$customer->company_phone" />
          <x-detail-field label="Website" :value="$customer->website" />
          <x-detail-field label="Address Line 1" :value="$customer->address_line1" />
          <x-detail-field label="Address Line 2" :value="$customer->address_line2" />
          <x-detail-field label="City" :value="$customer->city" />
          <x-detail-field label="Postal Code" :value="$customer->postal_code" />
          <x-detail-field label="Country" :value="$customer->country" />

          <x-detail-field label="SIREN" :value="$customer->siren" />
          <x-detail-field label="SIRET" :value="$customer->siret" />
          <x-detail-field label="Code APE" :value="$customer->ape_code" />

          <x-detail-field label="VAT Number" :value="$customer->vat_number" />
        </div>
      </x-show-info>
    </div>


    <div class="space-y-6">
      <x-show-info title="Contact Info">
        <div class="space-y-4">
          <x-detail-field label="Contact Name" :value="$customer->contact_name" />
          <x-detail-field label="Contact Email" :value="$customer->contact_email" />
          <x-detail-field label="Contact Phone" :value="$customer->contact_phone" />
        </div>
      </x-show-info>

      <x-show-info title="Record Info">
        <div class="space-y-3 text-gray-300 text-sm">
          <p><span class="text-gray-400">Created at:</span> {{ $customer->created_at->format('d M Y, H:i') }}</p>
          <p><span class="text-gray-400">Last update:</span> {{ $customer->updated_at->format('d M Y, H:i') }}</p>
        </div>
      </x-show-info>
    </div>
  </div>
  <div class="mt-8">
    <x-show-info title="Activity">
      @if($customer->bills->isNotEmpty())
      <div class="space-y-4">
        @foreach($customer->bills as $bill)
        <div class="p-4 border border-gray-700 rounded-lg flex items-center justify-between">
          <div>
            <p class="text-gray-200 font-medium">
              {{ ucfirst($bill->type) }} #{{ $bill->number }}
            </p>
            <p class="text-gray-400 text-sm">
              {{ $bill->created_at->format('d M Y') }}
            </p>
          </div>

          <x-bill.status-badge :bill="$bill" />


          <x-button :href="route('dashboard.bills.show', $bill->id)" variant="ghost" size="sm">
            Voir
          </x-button>
        </div>
        @endforeach
      </div>
      @else
      <p class="text-gray-500 italic">No activity yet.</p>
      @endif
    </x-show-info>

  </div>

</div>
@endsection