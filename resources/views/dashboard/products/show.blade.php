@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Details')

@section('content')
<div class="mx-auto">

  <x-button :href="route('dashboard.products.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" />
    Back
  </x-button>

  <div class="mx-auto mt-2 p-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Product Details</h1>
    <div class="flex items-center gap-3">
      <x-button :href="route('dashboard.products.edit', $product->id)" variant="info" size="sm" class="gap-2 py-0.5 w-22">
        <x-heroicon-o-pencil-square class="size-5" />
        Edit
      </x-button>

      <x-confirmation-delete-dialog
        :modelId="$product->id"
        modelName="product"
        route="dashboard.products.delete"
        variant="destructive">
        <div class="flex items-center gap-2 py-0.5">
          <x-heroicon-o-trash class="size-5" />
          <span>Delete</span>
        </div>
      </x-confirmation-delete-dialog>


    </div>
  </div>

  <x-show-info title="Product Info" :status="$product->status">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <x-detail-field label="Product Name" :value="$product->name" />
      <x-detail-field label="Type" :value="$product->type === 'time_unit' ? 'Time Unit' : 'Package'" />
      <x-detail-field label="Unit" :value="$product->unit ?? '-'" />
      <x-detail-field label="Base Price (€)" :value="number_format($product->base_price, 2)" />
    </div>
  </x-show-info>
</div>


</div>
@endsection