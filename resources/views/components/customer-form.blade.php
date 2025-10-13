@props([
'action' => route('dashboard.customers.store'),
'method' => 'POST',
'customer' => null
])

<form method="POST" action="{{ $action }}" id="customerForm" class="space-y-8">
    @csrf
    @if(in_array($method, ['PUT', 'PATCH']))
    @method($method)
    @endif

    <x-form.section title="Status">
        <x-form.select
            name="status"
            label="Status"
            required
            :value="old('status', $customer?->status)"
            :options="array_merge(
            [
                'prospect' => 'Prospect',
                'active' => 'Active',
            ],
            in_array($method, ['PUT', 'PATCH'])
                ? ['inactive' => 'Inactive']
                : []
            )"
            class="!w-1/3" />
    </x-form.section>

    <x-form.section title="Company Info">
        <x-form.input
            label="Company Name"
            name="company_name"
            :value="$customer?->company_name"
            required />

        <div class="flex flex-col md:flex-row gap-4">
            <x-form.input
                label="Company Email"
                name="company_email"
                type="email"
                :value="$customer?->company_email"
                required
                class="flex-1" />
            <x-form.input
                label="Company Phone"
                name="company_phone"
                type="tel"
                :value="$customer?->company_phone"
                optional
                class="flex-1" />
        </div>

        <div class="flex flex-col md:flex-row gap-4">
            <x-form.input
                label="Address Line 1"
                name="address_line1"
                :value="$customer?->address_line1"
                optional
                class="flex-1" />
            <x-form.input
                label="Address Line 2"
                name="address_line2"
                :value="$customer?->address_line2"
                optional
                class="flex-1" />
        </div>

        <div class="flex flex-col md:flex-row gap-4">
            <x-form.input
                label="Postal Code"
                name="postal_code"
                :value="$customer?->postal_code"
                class="flex-1" />
            <x-form.input
                label="City"
                name="city"
                :value="$customer?->city"
                class="flex-1" />
        </div>

        <div class="flex flex-col md:flex-row gap-4">
            <x-form.input
                label="Website"
                name="website"
                type="url"
                :value="$customer?->website"
                optional
                class="flex-1" />
            <x-form.input
                label="VAT Number"
                name="vat_number"
                :value="$customer?->vat_number"
                optional
                class="flex-1" />
        </div>
    </x-form.section>

    <x-form.section title="Contact Info" :separator="false">
        <x-form.input
            label="Contact Name"
            name="contact_name"
            :value="$customer?->contact_name"
            optional />

        <div class="flex flex-col md:flex-row gap-4">
            <x-form.input
                label="Contact Email"
                name="contact_email"
                type="email"
                :value="$customer?->contact_email"
                optional
                class="flex-1" />
            <x-form.input
                label="Contact Phone"
                name="contact_phone"
                type="tel"
                :value="$customer?->contact_phone"
                optional
                class="flex-1" />
        </div>
    </x-form.section>

    <div class="flex justify-end px-6">
        <x-button type="submit" variant="primary">
            {{ $customer ? 'Update' : 'Create' }}
        </x-button>
    </div>
</form>