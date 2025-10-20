@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Option Details')

@section('content')
<div class="mx-auto">

  <x-back-button />

  <div class="mx-auto mt-2 p-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Product Option Details</h1>
    <div class="flex items-center gap-3">
      <x-button :href="route('dashboard.products-options.edit', $productOption->id)" variant="info" size="sm" class="gap-2 py-0.5 w-22">
        <x-heroicon-o-pencil-square class="size-5" />
        Edit
      </x-button>

      <x-confirmation-delete-dialog
        :modelId="$productOption->id"
        modelName="product option"
        route="dashboard.products-options.delete"
        variant="destructive">
        <div class="flex items-center gap-2 py-0.5">
          <x-heroicon-o-trash class="size-5" />
          <span>Delete</span>
        </div>
      </x-confirmation-delete-dialog>
    </div>
  </div>

  <div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <x-show-info title="Option Info">
        <div class="grid grid-cols-2 gap-6">
          <x-detail-field label="Option Name" :value="$productOption->name" />
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
        <p class="text-gray-500">No products linked to this option yet.</p>
        @endif
      </x-show-info>
    </div>

    @if($productOption->values->count())
    <x-show-info title="Option Values">
      <div class="space-y-4">
        @foreach($productOption->values as $value)
        <div class="flex flex-col md:flex-row items-center justify-between w-full rounded-xl p-4 gap-4 bg-gray-900/90">
          <x-detail-field label="Value" :value="$value->value" class="w-full" />
          <x-detail-field label="Price (€)" :value="number_format($value->price ?? 0, 2)" />
          <x-detail-field label="Default" :value="$value->is_default ? '✅ Yes' : '❌ No'" />
        </div>
        @endforeach
      </div>
    </x-show-info>
    @endif

  </div>

</div>
@endsection