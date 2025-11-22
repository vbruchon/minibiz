@props([
'label',
'name',
'rows' => 4,
'value' => null,
'required' => false,
'optional' => false,
])

<div {{ $attributes->merge(['class' => '']) }}>
  <label class="block mb-2 font-semibold text-foreground">
    {{ $label }}
    @if($optional)
    <span class="text-sm font-normal text-muted-foreground">(optionnel)</span>
    @endif
  </label>

  <textarea
    name="{{ $name }}"
    rows="{{ $rows }}"
    class="w-full px-4 py-2 bg-input text-foreground border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
    @if($required) required @endif>{{ old($name, $value) }}</textarea>

  @error($name)
  <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
  @enderror
</div>