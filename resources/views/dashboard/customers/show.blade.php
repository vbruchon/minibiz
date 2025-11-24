@extends('layouts.dashboard')

@section('title', 'MiniBiz - Détail Client')

@section('content')
<div class="mx-auto">

  <x-back-button />

  <div class="mx-auto mt-4 p-8 space-y-8">
    <x-header
      title="Détail Client">
      <x-slot name="actions">
        <x-button :href="route('dashboard.customers.edit', $customer->id)" variant="info" size="sm" class="gap-2">
          <x-heroicon-o-pencil-square class="size-5" />
          Modifier
        </x-button>

        <x-confirmation-delete-dialog
          :modelId="$customer->id"
          modelName="customer"
          route="dashboard.customers.delete"
          variant="destructive">
          <div class="flex items-center gap-2">
            <x-heroicon-o-trash class="size-5" />
            <span>Supprimer</span>
          </div>
        </x-confirmation-delete-dialog>
      </x-slot>
    </x-header>

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

        <x-show-info title="Informations d’enregistrement">
          <div class="space-y-3 text-sm text-muted-foreground">
            <p><span class="text-muted-foreground">Créé le :</span>
              {{ $customer->created_at->format('d/m/Y H:i') }}
            </p>
            <p><span class="text-muted-foreground">Dernière modification :</span>
              {{ $customer->updated_at->format('d/m/Y H:i') }}
            </p>
          </div>
        </x-show-info>
      </div>
    </div>

    <div class="mt-8">
      <x-show-info title="Activity">
        @if($customer->bills->isNotEmpty())
        <div class="space-y-4">
          @foreach($customer->bills as $bill)
          <div class="p-4 bg-card border border-border rounded-lg flex items-center justify-between">
            <div>
              <p class="text-foreground font-medium">
                {{ ucfirst($bill->type) }} #{{ $bill->number }}
              </p>
              <p class="text-sm text-muted-foreground">
                {{ $bill->created_at->format('d/m/Y') }}
              </p>
            </div>

            @php
            $status = strtolower(trim($customer->status ?? ''));
            $colors = [
            'active' => 'bg-success/15 text-success border-success/30',
            'inactive' => 'bg-muted/20 text-muted-foreground border-muted/40',
            'prospect' => 'bg-warning/15 text-warning border-warning/30',
            ];
            @endphp

            <span class="block w-24 text-center px-3 py-1.5 text-sm rounded-md border 
                                    {{ $colors[$status] ?? $colors['inactive'] }}">
              {{ ucfirst($status) ?: '—' }}
            </span>

            <x-button :href="route('dashboard.bills.show', $bill->id)" variant="ghost" size="sm">
              Voir
            </x-button>
          </div>
          @endforeach
        </div>
        @else
        <p class="text-muted-foreground italic">Aucune activité.</p>
        @endif
      </x-show-info>
    </div>

  </div>
</div>
@endsection