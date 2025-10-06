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

    <!-- Nom -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">Name</label>
        <input type="text" name="name" value="{{ old('name', $customer?->name) }}" required
            class="w-full px-4 py-2 text-gray-100 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        @error('name')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between gap-6">
        <!-- Email -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">Email</label>
            <input type="email" name="email" value="{{ old('email', $customer?->email) }}" required
                class="w-full px-4 py-2 text-gray-100 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('email')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <!-- Téléphone -->
        <div class="w-full">
            <label class="block mb-2 font-semibold text-gray-200">
                Phone <span class="text-sm font-normal text-muted italic">(optionnal)</span>
            </label>
            <input type="tel" name="phone" value="{{ old('phone', $customer?->phone) }}"
                class="w-full px-4 py-2 text-gray-100 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('phone')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Adresse -->
    <div>
        <label class="block mb-2 font-semibold text-gray-200">
            Address <span class="text-sm font-normal text-gray-400">(optionnal)</span>
        </label>
        <input type="text" name="address" value="{{ old('address', $customer?->address) }}"
            class="w-full px-4 py-2 text-gray-100 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        @error('address')
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