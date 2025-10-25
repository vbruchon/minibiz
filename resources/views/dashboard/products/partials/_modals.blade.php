@foreach($product->options as $option)
@php $option->loadMissing('values'); @endphp
@include('dashboard.products.partials._option_modal_show', ['option' => $option])
@include('dashboard.products.partials._option_modal_edit', ['option' => $option, 'packageProducts' => $packageProducts])
@endforeach

@include('dashboard.products.partials._manage_options_modal')
@include('dashboard.products.partials._add_option_modal')

<x-modal id="productOptionModal">
  <div id="productOptionModal-content" class="modal-content"></div>
</x-modal>