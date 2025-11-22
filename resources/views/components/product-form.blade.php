@props([
'action' => route('dashboard.products.store'),
'method' => 'POST',
'product' => null
])

<form method="POST" action="{{ $action }}" id="productForm" class="space-y-10">
    @csrf
    @if(in_array($method, ['PUT', 'PATCH']))
    @method($method)
    @endif

    @if(in_array($method, ['PUT', 'PATCH']))
    <x-form.section title="Status" class="mb-6">
        <x-form.select
            name="status"
            required
            :value="old('status', $product?->status)"
            :options="['active' => 'Active', 'inactive' => 'Inactive']"
            class="!w-1/3" />
    </x-form.section>
    @endif

    <x-form.section title="Product Info" :separator="false" class="space-y-6">
        {{-- Product Name --}}
        <x-form.input
            label="Product Name"
            name="name"
            :value="$product?->name"
            required
            class="w-full" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.select
                label="Type"
                name="type"
                required
                :value="$product?->type"
                :options="['time_unit' => 'Time Unit', 'package' => 'Package']"
                class="w-full" />

            <x-form.input
                label="Unit"
                name="unit"
                :value="$product?->unit"
                optional
                class="w-full" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input
                label="Base Price (€)"
                name="base_price"
                type="number"
                step="0.01"
                :value="$product?->base_price"
                required
                class="w-full" />
        </div>
    </x-form.section>

    <div class="flex justify-end mt-8">
        <x-button type="submit" variant="primary" size="sm" class="px-6 py-3 text-lg">
            {{ $product ? 'Update Product' : 'Create Product' }}
        </x-button>
    </div>
</form>