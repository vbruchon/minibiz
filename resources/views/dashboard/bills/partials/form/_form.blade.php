<x-card>
  <form id="bill-form"
    action="{{ $formAction }}"
    method="POST"
    class="space-y-10">

    @csrf
    @if(isset($bill))
    @method('PUT')
    @endif

    <div class="space-y-10">
      @include('dashboard.bills.partials.form._customer')
      @include('dashboard.bills.partials.form._products')
      @include('dashboard.bills.partials.form._info')

      @if($type === 'invoice')
      @include('dashboard.bills.partials.form._payment')
      @endif

      @include('dashboard.bills.partials.form._summary')
      @include('dashboard.bills.partials.form._note')
    </div>

    <div class="flex justify-end mt-6">
      <x-button type="submit" variant="primary" size="sm">
        {{ $submitLabel }}
      </x-button>
    </div>
  </form>
</x-card>

@include('dashboard.bills.partials.form._bill-line-template')
@include('dashboard.bills.partials.form._option-template')

@vite(['resources/js/pages/bills/form.js'])