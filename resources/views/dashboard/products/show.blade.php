@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Details')

@section('content')
<div class="mx-auto space-y-6">
  <x-back-button />

  <x-header
    title="Détail Produit">
    <x-slot name="actions">
      <x-button :href="route('dashboard.products.edit', $product->id)" variant="info" size="sm" class="gap-2">
        <x-heroicon-o-pencil-square class="size-5" />
        Modifier
      </x-button>

      <x-confirmation-delete-dialog
        :modelId="$product->id"
        modelName="product"
        route="dashboard.products.delete"
        variant="destructive">
        <div class="flex items-center gap-2">
          <x-heroicon-o-trash class="size-5" />
          <span>Supprimer</span>
        </div>
      </x-confirmation-delete-dialog>
    </x-slot>
  </x-header>

  <div class="space-y-8 px-8">
    @include('dashboard.products.partials._product_info')
    @includeWhen($product->type === 'package', 'dashboard.products.partials._linked_options_table')
  </div>

  @include('dashboard.products.partials._modals')
</div>
@endsection

@push('scripts')
<script>
  window.initModalContent = (container) => {
    const form = container.querySelector('form[data-form="product-option"]');
    if (form && typeof window.initProductOptionForm === 'function') {
      window.initProductOptionForm(container);
    }
  };
</script>
@endpush