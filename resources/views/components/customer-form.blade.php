@props([
'action' => route('dashboard.customers.store'),
'method' => 'POST',
'customer' => null
])
<x-card>
    <form method="POST" action="{{ $action }}" id="customerForm" class="space-y-8">
        @csrf
        @if(in_array($method, ['PUT', 'PATCH']))
        @method($method)
        @endif

        <x-form.section title="Status">
            <x-form.select
                name="status"
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
                    placeholder="contact@entreprise.fr"
                    required
                    class="flex-1" />

                <x-form.input
                    label="Company Phone"
                    name="company_phone"
                    type="tel"
                    :value="$customer?->company_phone"
                    placeholder="+33 1 23 45 67 89"
                    optional
                    class="flex-1" />
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <x-form.input
                    label="Address Line 1"
                    name="address_line1"
                    :value="$customer?->address_line1"
                    placeholder="12 rue des Lilas"
                    optional
                    class="flex-1" />
                <x-form.input
                    label="Address Line 2"
                    name="address_line2"
                    :value="$customer?->address_line2"
                    placeholder="Bâtiment B, 2e étage"
                    optional
                    class="flex-1" />
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <x-form.input
                    label="Postal Code"
                    name="postal_code"
                    :value="$customer?->postal_code"
                    placeholder="75001"
                    class="flex-1" />
                <x-form.input
                    label="City"
                    name="city"
                    :value="$customer?->city"
                    placeholder="Paris"
                    class="flex-1" />
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <x-form.input
                    label="Country"
                    name="country"
                    :value="old('country', $customer?->country ?? 'France')"
                    placeholder="France"
                    optional
                    class="flex-1" />
                <x-form.input
                    label="SIREN"
                    name="siren"
                    :value="$customer?->siren"
                    placeholder="123456789"
                    optional
                    class="flex-1" />
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <x-form.input
                    label="SIRET"
                    name="siret"
                    :value="$customer?->siret"
                    placeholder="12345678900017"
                    required
                    class="flex-1" />
                <x-form.input
                    label="Code APE"
                    name="ape_code"
                    :value="$customer?->ape_code"
                    placeholder="5610A"
                    optional
                    class="flex-1" />
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <x-form.input
                    label="Website"
                    name="website"
                    type="url"
                    :value="$customer?->website"
                    placeholder="https://www.entreprise.fr"
                    optional
                    class="flex-1" />
                <x-form.input
                    label="VAT Number"
                    name="vat_number"
                    :value="$customer?->vat_number"
                    placeholder="FR12345678901"
                    optional
                    class="flex-1" />
            </div>
        </x-form.section>

        <x-form.section title="Contact Info" :separator="false">
            <x-form.input
                label="Contact Name"
                name="contact_name"
                :value="$customer?->contact_name"
                placeholder="Jean Dupont"
                optional />

            <div class="flex flex-col md:flex-row gap-4">
                <x-form.input
                    label="Contact Email"
                    name="contact_email"
                    type="email"
                    :value="$customer?->contact_email"
                    placeholder="jean.dupont@entreprise.fr"
                    optional
                    class="flex-1" />
                <x-form.input
                    label="Contact Phone"
                    name="contact_phone"
                    type="tel"
                    :value="$customer?->contact_phone"
                    placeholder="+33 6 12 34 56 78"
                    optional
                    class="flex-1" />
            </div>
        </x-form.section>

        <div class="flex justify-end px-6">
            <x-button type="submit" variant="primary" size="sm">
                {{ $customer ? 'Update' : 'Create' }}
            </x-button>
        </div>
    </form>
</x-card>