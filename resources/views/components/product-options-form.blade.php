@props([
'action' => route('dashboard.products-options.store'),
'method' => 'POST',
'option' => null,
'products' => [] // tableau [id => name] pour le select produit
])

<form method="POST" action="{{ $action }}" id="productOptionForm" class="space-y-10 py-8 px-6 rounded-2xl bg-gray-900/50 shadow-lg">
    @csrf
    @if(in_array($method, ['PUT', 'PATCH']))
    @method($method)
    @endif

    <x-form.section title="Product Option Details" class="space-y-6" :separator="false">

        <x-form.select
            name="product_id"
            label="Associated Product"
            required
            :value="old('product_id', $option?->product_id)"
            :options="$products"
            placeholder="Select a product"
            class="w-full" />

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
                :value="old('type', $option?->type)"
                :options="[
        'choose' => 'Choose a type',
        'text' => 'Text',
        'number' => 'Number',
        'checkbox' => 'Checkbox',
        'select' => 'Select (multiple values)',
        ]"
                placeholder="Select a type"
                class="w-full" />
        </div>

        <div id="default-value-wrapper" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
            <x-form.input
                label="Value"
                name="default_value"
                :value="old('default_value', $option?->default_value)"
                placeholder="ex: yes / 5 / blue"
                class="w-full" />

            <x-form.input
                label="Price (€)"
                name="default_price"
                type="number"
                step="0.01"
                :value="old('default_price', $option?->default_price)"
                placeholder="0.00"
                class="w-full" />
        </div>

        <div id="valuesContainer" class="space-y-2" style="display:none;">
            <label class="block text-gray-300 font-medium">Values</label>
            <div id="valuesList" class="space-y-2">
                @if(isset($option) && $option->values)
                @foreach($option->values as $index => $value)
                <div class="flex gap-2 items-center">
                    <input type="text" name="values[{{ $index }}][value]" value="{{ $value['value'] }}"
                        placeholder="Value" class="w-1/2 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="number" name="values[{{ $index }}][price]" value="{{ $value['price'] ?? 0 }}" step="0.01"
                        placeholder="Price (€)" class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="radio" name="default_index" value="{{ $index }}" {{ $value['is_default'] ?? false ? 'checked' : '' }} title="Default" class="cursor-pointer" />
                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 removeValue">×</button>
                </div>
                @endforeach
                @else
                <div class="flex gap-2 items-center">
                    <input type="text" name="values[0][value]" placeholder="Value" class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <input type="number" name="values[0][price]" placeholder="Price (€)" step="0.01" class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
                    <div class="p-2">
                        <input type="radio" name="default_index" value="0" title="Default" class="cursor-pointer" />
                    </div>
                    <x-button type="button" variant="ghost" size="sm" class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
                </div>
                @endif
            </div>
            <x-button type="button" id="addValueBtn" variant="ghost" size="md" class="!text-blue-500 hover:!text-blue-700 !px-0">
                + Add Value
            </x-button>
        </div>

    </x-form.section>

    <div class="flex justify-end mt-8 mr-8">
        <x-button type="submit" variant="primary">
            {{ $option ? 'Update Option' : 'Create Option' }}
        </x-button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const typeSelect = document.querySelector('select[name="type"]');
        const valuesContainer = document.getElementById('valuesContainer');
        const valuesList = document.getElementById('valuesList');
        const addValueBtn = document.getElementById('addValueBtn');
        const defaultValueWrapper = document.querySelector('#default-value-wrapper');

        const toggleFields = () => {
            const type = typeSelect.value;

            const showDefault = ['text', 'number'].includes(type);
            defaultValueWrapper.style.display = showDefault ? 'grid' : 'none';

            valuesContainer.style.display = ['select', 'checkbox'].includes(type) ? 'block' : 'none';
        };

        typeSelect.addEventListener('change', toggleFields);
        toggleFields();

        addValueBtn.addEventListener('click', () => {
            const index = valuesList.children.length;
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center';
            div.innerHTML = `
        <input type="text" name="values[${index}][value]" placeholder="Value"
            class="w-1/3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
        <input type="number" name="values[${index}][price]" placeholder="Price (€)" step="0.01"
            class="w-1/4 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2" />
        <div class="p-2">
            <input type="radio" name="default_index" value="${index}" title="Default" class="cursor-pointer" />
        </div>
        <x-button type="button" variant="ghost" size="sm"
            class="!py-1 !text-3xl !text-destructive hover:!text-destructive/70 removeValue">×</x-button>
    `;
            valuesList.appendChild(div);
            attachRemoveEvent(div.querySelector('.removeValue'));
        });

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
    });
</script>