@extends('layouts.dashboard')

@section('title', 'MiniBiz - Facturation')

@section('content')
<div class="mx-auto">
  <x-header
    title="Facturation">
    <x-slot name="actions">
      <x-button
        :href="route('dashboard.bills.create', ['type' => 'quote'])"
        variant="primary"
        size="sm"
        class="flex items-center gap-2">
        <x-heroicon-o-plus class="size-4" />
        Créer un devis
      </x-button>

      <x-button
        :href="route('dashboard.bills.create', ['type' => 'invoice'])"
        variant="outline"
        size="sm"
        class="flex items-center gap-2">
        <x-heroicon-o-plus class="size-4" />
        Créer une facture
      </x-button>
    </x-slot>
  </x-header>

  <div class="w-1/3">
    <x-list-controls
      route="dashboard.bills.index"
      searchPlaceholder="Search in facture/devis..."
      searchName="s"
      :filters="[
        [
          'name' => 'type',
          'label' => 'Type',
          'options' => [
              'quote' => 'Devis',
              'invoice' => 'Facture',
          ],
        ],
        [
          'name' => 'status',
          'label' => 'Statut',
          'options' => collect(\App\Enums\BillStatus::cases())
              ->mapWithKeys(fn($s) => [$s->value => $s->label()])
              ->toArray(),
        ]
      ]" />
  </div>

  <div class="overflow-x-auto overflow-y-hidden bg-card border border-border rounded-xl shadow-sm">
    <x-table
      :headers="[
        ['label' => 'Numéro', 'sortable' => true, 'column' => 'number'],
        ['label' => 'Type', 'sortable' => true, 'column' => 'type'],
        ['label' => 'Statut', 'sortable' => true, 'column' => 'status'],
        ['label' => 'Client', 'sortable' => true, 'column' => 'customer_id'],
        ['label' => 'Total', 'sortable' => true, 'column' => 'total'],
        ['label' => 'Date', 'sortable' => true, 'column' => 'issue_date'],
        ['label' => 'Actions'],
      ]"
      route="dashboard.bills.index"
      :rowsCount="$bills->count()">

      @foreach ($bills as $bill)
      @include('dashboard.bills.partials._rows', ['bill' => $bill])
      @endforeach
    </x-table>
  </div>

  <div class="mt-4">
    {{ $bills->links() }}
  </div>

</div>

@include('dashboard.bills.partials.show._convert_modal', [
'paymentLabels' => $paymentLabels,
'billId' => null
])

@endsection


@push('scripts')
<script>
  document.querySelectorAll('[data-modal-target="convert-modal"]').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.dataset.billId;
      const form = document.getElementById("convert-form");
      form.action = `/dashboard/bills/${id}/convert`;
    });
  });
</script>
@endpush