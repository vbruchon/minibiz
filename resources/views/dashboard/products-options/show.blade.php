@extends('layouts.dashboard')

@section('title', 'MiniBiz - Détails option produit')

@section('content')
<div class="mx-auto space-y-6">

  <x-back-button />

  <x-header
    title="Détails de l'option">
    <x-slot name="actions">
      <x-button :href="route('dashboard.products-options.edit', $productOption->id)"
        variant="info" size="sm" class="gap-2">
        <x-heroicon-o-pencil-square class="size-5" />
        Modifier
      </x-button>

      <x-confirmation-delete-dialog
        :modelId="$productOption->id"
        modelName="product option"
        route="dashboard.products-options.delete"
        variant="destructive">
        <div class="flex items-center gap-2">
          <x-heroicon-o-trash class="size-5" />
          <span>Supprimer</span>
        </div>
      </x-confirmation-delete-dialog>
    </x-slot>
  </x-header>

  <div class="space-y-8 px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <x-show-info title="Informations de l'option">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <x-detail-field label="Nom" :value="$productOption->name" />
          <x-detail-field label="Type" :value="ucfirst($productOption->type)" />
        </div>
      </x-show-info>

      <x-show-info title="Linked Products">
        @if($productOption->products->count())
        <div class="grid grid-cols-2 gap-6">
          @foreach($productOption->products as $product)
          <x-detail-field label="Product Name" :value="$product->name" />
          @if(in_array($productOption->type, ['text', 'number']))
          <x-detail-field label="Default Value" :value="$product->pivot->default_value ?? '-'" />
          <x-detail-field label="Default Price (€)" :value="number_format($product->pivot->default_price ?? 0, 2)" />
          <x-detail-field label="Attached by Default" :value=" $product->pivot->is_default_attached ? '✅ Yes' : '❌ No'" />
          @endif
          @endforeach
        </div>
        @else
        <p class="text-muted-foreground">No products linked to this option yet.</p>
        @endif
      </x-show-info>
    </div>

    @if($productOption->values->count())
    <x-show-info title="Valeurs de l'option">
      <div class="space-y-4">
        @foreach($productOption->values as $value)
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 w-full rounded-xl p-4 bg-card border border-border">
          <x-detail-field label="Valeur" :value="$value->value" class="w-full" />
          <x-detail-field label="Prix (€)" :value="number_format($value->price ?? 0, 2)" />
          <x-detail-field label="Par défaut" :value="$value->is_default ? 'Oui' : 'Non'" />
        </div>
        @endforeach
      </div>
    </x-show-info>
    @endif
  </div>
</div>
@endsection