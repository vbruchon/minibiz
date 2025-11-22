@if ($paginator->hasPages())
<nav
    role="navigation"
    aria-label="Pagination Navigation"
    class="flex items-center justify-between mt-4">
    {{-- Mobile --}}
    <div class="flex justify-between flex-1 sm:hidden">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
        <span
            class="px-4 py-2 text-sm font-medium bg-card border border-border text-muted-foreground rounded-lg cursor-default">
            {!! __('pagination.previous') !!}
        </span>
        @else
        <a
            href="{{ $paginator->previousPageUrl() }}"
            class="px-4 py-2 text-sm font-medium bg-card border border-border text-foreground rounded-lg hover:bg-muted/10 transition">
            {!! __('pagination.previous') !!}
        </a>
        @endif

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <a
            href="{{ $paginator->nextPageUrl() }}"
            class="px-4 py-2 text-sm font-medium bg-card border border-border text-foreground rounded-lg hover:bg-muted/10 transition">
            {!! __('pagination.next') !!}
        </a>
        @else
        <span
            class="px-4 py-2 text-sm font-medium bg-card border border-border text-muted-foreground rounded-lg cursor-default">
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    {{-- Desktop --}}
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-end sm:gap-4">
        {{-- Counter --}}
        <p class="text-sm text-muted-foreground">
            @if ($paginator->firstItem())
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
            {{ $paginator->count() }}
            @endif
            sur
            <span class="font-medium">{{ $paginator->total() }}</span>
        </p>

        {{-- Buttons --}}
        <span class="inline-flex rounded-lg border border-border bg-card overflow-hidden">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
            <span
                class="px-3 py-2 text-sm text-muted-foreground cursor-default">
                ‹
            </span>
            @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-2 text-sm text-foreground hover:bg-muted/10 transition">
                ‹
            </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
            @if (is_string($element))
            <span class="px-3 py-2 text-sm text-muted-foreground">
                {{ $element }}
            </span>
            @endif

            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <span
                aria-current="page"
                class="px-3 py-2 text-sm font-semibold bg-primary text-primary-foreground">
                {{ $page }}
            </span>
            @else
            <a
                href="{{ $url }}"
                class="px-3 py-2 text-sm text-foreground hover:bg-muted/10 transition">
                {{ $page }}
            </a>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-2 text-sm text-foreground hover:bg-muted/10 transition">
                ›
            </a>
            @else
            <span
                class="px-3 py-2 text-sm text-muted-foreground cursor-default">
                ›
            </span>
            @endif

        </span>
    </div>
</nav>
@endif