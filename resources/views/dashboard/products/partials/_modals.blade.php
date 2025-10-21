@foreach($product->options as $option)
@include('dashboard.products.partials._option_modal_show', ['option' => $option])
@include('dashboard.products.partials._option_modal_edit', ['option' => $option, 'packageProducts' => $packageProducts])
@endforeach

@include('dashboard.products.partials._manage_options_modal')
@include('dashboard.products.partials._add_option_modal')

{{-- Containers pour injection dynamique --}}
<x-modal id="productOptionModal">
  <div id="productOptionModal-content"></div>
</x-modal>