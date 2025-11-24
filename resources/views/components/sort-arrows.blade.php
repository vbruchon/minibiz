@props([
'column',
'route' => null,
])

@php
$route = $route ?? request()->route()->getName();
$isAsc = request('sort') === $column && request('dir') === 'asc';
$isDesc = request('sort') === $column && request('dir') === 'desc';
@endphp

<div class="flex flex-col">
    <a
        href="{{ route($route, array_merge(request()->except(['page']), ['sort' => $column, 'dir' => 'asc'])) }}"
        class="{{ $isAsc ? 'text-primary' : 'text-muted-foreground' }} hover:text-primary transition">
        <x-heroicon-s-chevron-up class="size-3" />
    </a>

    <a
        href="{{ route($route, array_merge(request()->except(['page']), ['sort' => $column, 'dir' => 'desc'])) }}"
        class="{{ $isDesc ? 'text-primary' : 'text-muted-foreground' }} hover:text-primary transition">
        <x-heroicon-s-chevron-down class="size-3" />
    </a>
</div>