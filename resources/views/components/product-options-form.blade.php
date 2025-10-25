@props([
'action' => route('dashboard.products-options.store'),
'method' => 'POST',
'option' => null,
'products' => [],
'selectedProductId' => null,
])

@php
$selectedProductId = $selectedProductId
?? old('product_id')
?? $option?->products->first()?->id
?? null;

$defaultValue = old('default_value')
?? $option?->products->first()?->pivot->default_value
?? null;

$defaultPrice = old('default_price')
?? $option?->products->first()?->pivot->default_price
?? 0;



$values = old('values')
?? (collect($option?->values ?? [])->map(fn($v) => [
'id' => $v['id'] ?? $v->id,
'value' => $v['value'] ?? $v->value,
'price' => $v['price'] ?? $v->price,
'is_default' => $v['is_default'] ?? $v->is_default,
])->toArray());

$defaultIndex = old('default_index')
?? collect($values)->firstWhere('is_default', true)['id'] ?? null;

@endphp

<form method="POST" action="{{ $action }}" data-form="product-option" class="space-y-10 py-8 px-6">
    @csrf
    @if(in_array($method, ['PUT', 'PATCH']))
    @method($method)
    @endif

    <x-form.section title="Product Option Details" class="space-y-6" :separator="false">
        {{-- Associated Products --}}
        <div class="mb-8">
            <label class="block mb-2 font-semibold text-gray-200">Associated Products</label>
            <div class="flex items-center flex-wrap gap-6 ml-4">
                @foreach($products as $id => $name)
                <label class="inline-flex items-center gap-1.5 text-gray-200">
                    <input
                        type="checkbox"
                        name="product_id[]"
                        value="{{ $id }}"
                        id="product_{{ $id }}"
                        @if( ($selectedProductId && $selectedProductId==$id) ||
                        in_array($id, old('product_id', $option?->products->pluck('id')->toArray() ?? []))
                    ) checked @endif
                    class="w-4 h-4 rounded border-gray-600 bg-gray-700 focus:ring-2 focus:ring-primary">
                    <span>{{ $name }}</span>
                </label>
                @endforeach
            </div>
            @error('product_id')
            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        {{-- Option Name & Type --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-form.input
                label="Option Name"
                name="name"
                :value="old('name', $option?->name)"
                required
                class="w-full" />

            <x-form.select
                label="Type"
                name="type"
                required
                :selected="old('type', $option?->type)"
                :options="[
                    'choose' => 'Choose a type',
                    'text' => 'Text',
                    'number' => 'Number',
                    'checkbox' => 'Checkbox',
                    'select' => 'Select (multiple values)',
                ]"
                class="w-full" />
        </div>

        {{-- Default value for text/number --}}
        <div id="default-value-wrapper" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
            <x-form.input
                label="Value"
                name="default_value"
                :value="$defaultValue"
                placeholder="ex: yes / 5 / blue"
                class="w-full" />
            <x-form.input
                label="Price (€)"
                name="default_price"
                type="number"
                step="0.01"
                :value="$defaultPrice"
                placeholder="0.00"
                class="w-full" />
        </div>

        {{-- Values for select/checkbox --}}
        <div id="valuesContainer" class="space-y-2" style="display:none;">
            <label class="block text-gray-300 font-medium">Values</label>
            <div id="valuesList" class="space-y-2">
                @if(!empty($values))
                @foreach($values as $value)
                <div class="flex gap-2 items-center">
                    <input type="text" name="values[{{ $value['id'] }}][value]" value="{{ $value['value'] }}"
                        placeholder="Value"
                        class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="number" name="values[{{ $value['id'] }}][price]" value="{{ $value['price'] ?? 0 }}" step="0.01"
                        placeholder="Price (€)"
                        class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="radio" name="default_index" value="{{ $value['id'] }}" title="Default" class="cursor-pointer"
                        {{ $value['id'] == $defaultIndex ? 'checked' : '' }} />
                    <x-button type="button" variant="ghost" size="sm"
                        class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
                </div>
                @endforeach
                @else
                <div class="flex gap-2 items-center">
                    <input type="text" name="values[0][value]" placeholder="Value"
                        class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="number" name="values[0][price]" placeholder="Price (€)" step="0.01"
                        class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="radio" name="default_index" value="0" title="Default" class="cursor-pointer" />
                    <x-button type="button" variant="ghost" size="sm"
                        class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
                </div>
                @endif
            </div>
            <x-button type="button" id="addValueBtn" variant="ghost" size="md" class="!text-blue-500 hover:!text-blue-700 !px-0">
                + Add Value
            </x-button>
        </div>

    </x-form.section>

    {{-- Submit --}}
    <div class="flex justify-end mt-8 mr-8">
        <x-button type="submit" variant="primary" size="sm">
            {{ $option ? 'Update Option' : 'Create Option' }}
        </x-button>
    </div>
</form>

<script>
    window.initProductOptionForm = (container = document) => {
        const typeSelect = container.querySelector('select[name="type"]');
        const valuesContainer = container.querySelector('#valuesContainer');
        const valuesList = container.querySelector('#valuesList');
        const addValueBtn = container.querySelector('#addValueBtn');
        const defaultValueWrapper = container.querySelector('#default-value-wrapper');

        if (!typeSelect) return;

        const toggleFields = () => {
            const type = typeSelect.value;
            defaultValueWrapper.style.display = ['text', 'number'].includes(type) ? 'grid' : 'none';
            valuesContainer.style.display = ['select', 'checkbox'].includes(type) ? 'block' : 'none';
        };

        typeSelect.addEventListener('change', toggleFields);
        toggleFields();

        const attachRemoveEvent = (btn) => {
            btn.addEventListener('click', () => {
                btn.parentElement.remove();
                Array.from(valuesList.children).forEach((div, i) => {
                    div.querySelector('input[type="text"]').name = `values[${i}][value]`;
                    div.querySelector('input[type="number"]').name = `values[${i}][price]`;
                    div.querySelector('input[type="radio"]').value = i;
                });
            });
        };

        Array.from(valuesList.querySelectorAll('.removeValue')).forEach(attachRemoveEvent);

        addValueBtn.addEventListener('click', () => {
            const index = valuesList.children.length;
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center';
            div.innerHTML = `
            <input type="text" name="values[${index}][value]" placeholder="Value" class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
            <input type="number" name="values[${index}][price]" placeholder="Price (€)" step="0.01" class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
            <input type="radio" name="default_index" value="${index}" title="Default" class="cursor-pointer" />
            <x-button type="button" variant="ghost" size="sm" class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
        `;
            valuesList.appendChild(div);
            attachRemoveEvent(div.querySelector('.removeValue'));
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        window.initProductOptionForm();
    });
</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const typeSelect = document.querySelector('select[name="type"]');
        const valuesContainer = document.getElementById('valuesContainer');
        const valuesList = document.getElementById('valuesList');
        const addValueBtn = document.getElementById('addValueBtn');
        const defaultValueWrapper = document.getElementById('default-value-wrapper');

        const toggleFields = () => {
            const type = typeSelect.value;
            defaultValueWrapper.style.display = ['text', 'number'].includes(type) ? 'grid' : 'none';
            valuesContainer.style.display = ['select', 'checkbox'].includes(type) ? 'block' : 'none';
        };

        typeSelect.addEventListener('change', toggleFields);
        toggleFields();

        const attachRemoveEvent = (btn) => {
            btn.addEventListener('click', () => {
                btn.parentElement.remove();
                Array.from(valuesList.children).forEach((div, i) => {
                    div.querySelector('input[type="text"]').name = `values[${i}][value]`;
                    div.querySelector('input[type="number"]').name = `values[${i}][price]`;
                    div.querySelector('input[type="radio"]').value = i;
                });
            });
        };

        Array.from(valuesList.querySelectorAll('.removeValue')).forEach(attachRemoveEvent);

        addValueBtn.addEventListener('click', () => {
            const index = valuesList.children.length;
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center';
            div.innerHTML = `
            <input type="text" name="values[${index}][value]" placeholder="Value" class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
            <input type="number" name="values[${index}][price]" placeholder="Price (€)" step="0.01" class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
            <input type="radio" name="default_index" value="${index}" title="Default" class="cursor-pointer" />
            <x-button type="button" variant="ghost" size="sm" class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
        `;
            valuesList.appendChild(div);
            attachRemoveEvent(div.querySelector('.removeValue'));
        });
    });
</script> -->