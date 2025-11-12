@props([
'label' => null,
'name',
'options' => [],
'selected' => null,
'required' => false,
'optional' => false,
'placeholder' => 'Sélectionner une option',
])

<div>
  @if($label)
  <label class="block mb-2 font-semibold text-gray-200">
    {{ $label }}
    @if($optional)
    <span class="text-sm font-normal text-gray-400">(optionnel)</span>
    @endif
  </label>
  @endif

  <select
    name="{{ $name }}"
    @if($required) required @endif
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2.5 bg-gray-700 text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition'
    ]) }}>

    <option value="" disabled {{ old($name, $selected) ? '' : 'selected' }}>
      {{ $placeholder }}
    </option>

    @foreach($options as $value => $text)
    <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
      {{ $text }}
    </option>
    @endforeach
  </select>

  @error($name)
  <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
  @enderror
</div>