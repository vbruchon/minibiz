@props([
'label',
'name',
'type' => 'text',
'value' => null,
'required' => false,
'optional' => false,
'placeholder' => null,
'id' => null,
'containerId' => null,
])

<div {{ $attributes->merge(['class' => '']) }}
  @if($containerId) id="{{$containerId}}" @endif>
  <label class="block mb-2 font-semibold text-gray-200">
    {{ $label }}
    @if($optional)
    <span class="text-sm font-normal text-gray-400">(optionnel)</span>
    @endif
  </label>

  <input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    @if($id) id="{{$id}}" @endif
    @if($required) required @endif
    @if($placeholder) placeholder="{{$placeholder}}" @endif

    class="w-full px-4 py-2 text-foreground bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">

  @error($name)
  <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
  @enderror
</div>