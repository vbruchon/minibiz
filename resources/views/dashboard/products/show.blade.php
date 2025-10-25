@extends('layouts.dashboard')

@section('title', 'MiniBiz - Product Details')

@section('content')
<div class="mx-auto">
  <x-back-button />

  <div class="mx-auto mt-2 px-8 py-4 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Product Details</h1>
  </div>

  <div class="space-y-6">
    @include('dashboard.products.partials._product_info')
    @includeWhen($product->type === 'package', 'dashboard.products.partials._linked_options_table')
  </div>

  @include('dashboard.products.partials._modals')

</div>
@endsection

@section('scripts')
<script>
  window.initModalContent = (container) => {
    const form = container.querySelector('form[data-form="product-option"]');
    if (form && typeof window.initProductOptionForm === 'function') {
      window.initProductOptionForm(container);
    }
  };
</script>
@endsection