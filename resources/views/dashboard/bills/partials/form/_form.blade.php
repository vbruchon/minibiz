<form id="bill-form"
  action="{{ $formAction }}"
  method="POST"
  class="mx-auto max-w-6xl space-y-10 bg-gradient-to-br from-gray-900/60 to-gray-800/60 
             rounded-2xl p-10 shadow-2xl backdrop-blur-md border border-white/10
             transition-all duration-300 hover:border-primary/30">

  @csrf
  @if(isset($bill))
  @method('PUT')
  @endif

  @include('dashboard.bills.partials.form._customer')
  @include('dashboard.bills.partials.form._products')
  @include('dashboard.bills.partials.form._info')
  @include('dashboard.bills.partials.form._payment')
  @include('dashboard.bills.partials.form._summary')
  @include('dashboard.bills.partials.form._note')

  <div class="flex justify-end mt-6">
    <x-button type="submit" variant="primary" size="sm">
      {{ $submitLabel }}
    </x-button>
  </div>
</form>

@include('dashboard.bills.partials.form._bill-line-template')
@include('dashboard.bills.partials.form._option-template')

@vite(['resources/js/pages/bills/form.js'])