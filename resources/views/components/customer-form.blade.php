@props([
'action' => route('customers.store'), // action par défaut pour create
'method' => 'POST', // méthode par défaut
'customer' => null // client existant pour update
])

<form method="POST" action="{{ $action }}" id="customerForm" class="space-y-6">
    @csrf
    @if(in_array($method, ['PUT', 'PATCH']))
    @method($method)
    @endif

    <!-- Company Name -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">Company Name</label>
        <input type="text" name="company_name" value="{{ old('company_name', $customer?->company_name) }}" required
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
        @error('company_name')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between gap-6">
        <!-- Company Email -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">Company Email</label>
            <input type="email" name="company_email" value="{{ old('company_email', $customer?->company_email) }}" required
                class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            @error('company_email')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <!-- Company Phone -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">
                Company Phone <span class="text-sm font-normal text-muted italic">(optional)</span>
            </label>
            <input type="tel" name="company_phone" value="{{ old('company_phone', $customer?->company_phone) }}"
                class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            @error('company_phone')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Address -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">Address Line 1 <span class="text-sm font-normal text-gray-400">(optional)</span></label>
        <input type="text" name="address_line1" value="{{ old('address_line1', $customer?->address_line1) }}"
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
        @error('address_line1')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block mb-2 font-semibold text-gray-200">Address Line 2 <span class="text-sm font-normal text-gray-400">(optional)</span></label>
        <input type="text" name="address_line2" value="{{ old('address_line2', $customer?->address_line2) }}"
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
        @error('address_line2')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between gap-6">
        <!-- Postal Code -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">Postal Code</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $customer?->postal_code) }}"
                class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            @error('postal_code')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <!-- City -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">City</label>
            <input type="text" name="city" value="{{ old('city', $customer?->city) }}"
                class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            @error('city')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Website -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">Website <span class="text-sm font-normal text-gray-400">(optional)</span></label>
        <input type="url" name="website" value="{{ old('website', $customer?->website) }}"
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
        @error('website')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <!-- VAT Number -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">VAT Number <span class="text-sm font-normal text-gray-400">(optional)</span></label>
        <input type="text" name="vat_number" value="{{ old('vat_number', $customer?->vat_number) }}"
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
        @error('vat_number')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <!-- Contact -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">Contact Name <span class="text-sm font-normal text-gray-400">(optional)</span></label>
        <input type="text" name="contact_name" value="{{ old('contact_name', $customer?->contact_name) }}"
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
        @error('contact_name')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between gap-6">
        <!-- Contact Email -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">Contact Email <span class="text-sm font-normal text-gray-400">(optional)</span></label>
            <input type="email" name="contact_email" value="{{ old('contact_email', $customer?->contact_email) }}"
                class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            @error('contact_email')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contact Phone -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">Contact Phone <span class="text-sm font-normal text-gray-400">(optional)</span></label>
            <input type="tel" name="contact_phone" value="{{ old('contact_phone', $customer?->contact_phone) }}"
                class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            @error('contact_phone')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Status -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">Status</label>
        <select name="status" required
            class="w-full px-4 py-2 text-foureground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
            <option value="active" {{ old('status', $customer?->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $customer?->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="prospect" {{ old('status', $customer?->status) === 'prospect' ? 'selected' : '' }}>Prospect</option>
        </select>
        @error('status')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <!-- Actions -->
    <div class="flex justify-end">
        <button type="submit"
            class="px-6 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-primary/70 hover:cursor-pointer">
            {{ $customer ? 'Update' : 'Enregistrer' }}
        </button>
    </div>
</form>