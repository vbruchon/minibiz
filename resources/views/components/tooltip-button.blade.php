@props(['label' => ''])

<span class="relative inline-flex">

  <span class="peer inline-flex">
    {{ $slot }}
  </span>

  <span class="pointer-events-none absolute top-full mt-2 left-1/2 -translate-x-1/2
                 whitespace-nowrap rounded bg-primary px-2 py-1 text-xs text-white
                 opacity-0 transition duration-150 z-50 shadow-lg
                 peer-hover:opacity-100">
    {{ $label }}
  </span>

</span>