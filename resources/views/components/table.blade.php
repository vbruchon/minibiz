@props([
'headers' => [],
'route' => null,
'empty' => 'No data found',
'rowsCount' => 0,
])

<table class="min-w-full divide-y divide-border">
  <thead class="bg-muted/20">
    <tr>
      @foreach ($headers as $header)
      <th class="px-6 py-3 text-left text-sm font-medium text-muted-foreground uppercase tracking-wider">
        @if (!empty($header['sortable']) && $header['sortable'] === true && $route)
        <div class="flex items-center gap-4">
          <span>{{ $header['label'] }}</span>
          <x-sort-arrows :column="$header['column']" :route="$route" />
        </div>
        @else
        {{ $header['label'] }}
        @endif
      </th>
      @endforeach
    </tr>
  </thead>

  <tbody class="divide-y divide-border">
    @if($rowsCount > 0)
    {{ $slot }}
    @else
    <tr>
      <td colspan="{{ count($headers) }}" class="px-6 py-3 text-center text-muted-foreground">
        {{ $empty }}
      </td>
    </tr>
    @endif
  </tbody>
</table>