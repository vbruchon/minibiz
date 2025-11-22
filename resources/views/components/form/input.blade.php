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
  <label class="block mb-2 font-semibold text-foreground">
    {{ $label }}
    @if($optional)
    <span class="text-sm font-normal text-muted-foreground">(optionnel)</span>
    @endif
  </label>

  <input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    id="{{ $id }}"
    placeholder="{{ $placeholder }}"
    @if($required) required @endif
    class="w-full px-4 py-2 bg-input text-foreground border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" />

  @error($name)
  <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
  @enderror
</div>