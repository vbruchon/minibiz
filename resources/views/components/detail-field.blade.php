@props(['label', 'value' => null])

<div class="w-full">
  <p class="text-sm text-gray-400 mb-1 font-medium">{{ $label }}</p>
  <div class="w-full bg-gray-700/40 border border-gray-600 rounded-lg px-4 py-2.5 text-gray-100 text-sm">
    {{ $value ?? '—' }}
  </div>
</div>