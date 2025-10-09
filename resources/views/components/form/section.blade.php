@props(['title' => null, 'separator' => true])

<div class="px-6 space-y-4">
  @if($title)
  <h3 class="text-xl font-semibold text-muted mb-4">{{ $title }}</h3>
  @endif

  <div class="space-y-6">
    {{ $slot }}
  </div>

  @if($separator)
  <div class="h-[1px] w-[70%] bg-muted mx-auto mt-8"></div>
  @endif

</div>