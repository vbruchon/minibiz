@extends('layouts.dashboard')

@section('title', 'MiniBiz - Customer Details')

@section('content')
<div class="mx-auto">

  <x-button :href="route('customers.index')" variant="secondary" size="sm" class="flex items-center gap-2">
    <x-heroicon-s-arrow-left class="size-4" />
    Back
  </x-button>

  <div class=" mx-auto mt-2 p-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-foreground">Customer Details</h1>
    <div class="flex items-center gap-3">
      <x-button :href="route('customers.edit', $customer->id)" variant="info" size="sm" class="gap-2 py-0.5 w-22">
        <x-heroicon-o-pencil-square class="size-5" />
        Edit
      </x-button>

      <x-confirmation-delete-dialog customerId="{{ $customer->id }}" variant="destructive">
        <div class="flex items-center gap-2 py-0.5">
          <x-heroicon-o-trash class="size-5" />
          <span>Delete</span>
        </div>
      </x-confirmation-delete-dialog>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 space-y-8">
      <x-show-info title="Company Info" :status="$customer->status">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <x-detail-field label="Company Name" :value="$customer->company_name" />
          <x-detail-field label="Email" :value="$customer->company_email" />
          <x-detail-field label="Phone" :value="$customer->company_phone" />
          <x-detail-field label="Website" :value="$customer->website" />
          <x-detail-field label="Address Line 1" :value="$customer->address_line_1" />
          <x-detail-field label="Address Line 2" :value="$customer->address_line_2" />
          <x-detail-field label="City" :value="$customer->city" />
          <x-detail-field label="Postal Code" :value="$customer->postal_code" />
          <x-detail-field label="VAT Number" :value="$customer->vat_number" />
        </div>
      </x-show-info>
    </div>

    <div class="space-y-6">
      <x-show-info title="Contact Info">
        <div class="space-y-4">
          <x-detail-field label="Contact Name" :value="$customer->contact_name" />
          <x-detail-field label="Contact Email" :value="$customer->contact_email" />
          <x-detail-field label="Contact Phone" :value="$customer->contact_phone" />
        </div>
      </x-show-info>

      <x-show-info title="Record Info">
        <div class="space-y-3 text-gray-300 text-sm">
          <p><span class="text-gray-400">Created at:</span> {{ $customer->created_at->format('d M Y, H:i') }}</p>
          <p><span class="text-gray-400">Last update:</span> {{ $customer->updated_at->format('d M Y, H:i') }}</p>
        </div>
      </x-show-info>
    </div>
  </div>
  <div class="mt-8">
    <x-show-info title="Activity">
      @if($customer->notes)
      <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $customer->notes }}</p>
      @else
      <p class="text-gray-500 italic">No activity yet.</p>
      @endif
    </x-show-info>
  </div>

</div>
@endsection