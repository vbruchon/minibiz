@props([
'title' => '',
'status' => null,
])

<div class="bg-gray-900/70 rounded-2xl p-8 shadow-lg">
  <div class="flex items-center justify-between mb-6 border-b border-gray-700 pb-2">
    <h2 class="text-xl font-semibold text-white">{{ $title }}</h2>

    @if($status)
    <span class="px-3 py-1.5 text-sm rounded-md {{
                strtolower(trim($status)) === 'active'
                    ? 'bg-green-600/20 text-green-400 border border-green-500/30'
                    : (strtolower(trim($status)) === 'inactive'
                        ? 'bg-gray-600/20 text-gray-400 border border-gray-500/30'
                        : 'bg-yellow-600/20 text-yellow-400 border border-yellow-500/30')
            }}">
      {{ ucfirst(strtolower(trim($status))) ?: '—' }}
    </span>
    @endif
  </div>

  <div>
    {{ $slot }}
  </div>
</div>