<table class="w-full table-auto border-collapse text-[14px] leading-tight">
  <thead>
    <tr class="bg-gray-100 border-b border-gray-300 text-gray-700">
      <th class="text-left py-2 px-3 font-semibold w-fit">Produit</th>
      <th class="text-left py-2 px-3 font-semibold">{{$optionsHeader}}</th>
      <th class="text-right py-2 px-3 font-semibold w-fit whitespace-nowrap">Qté</th>
      <th class="text-right py-2 px-3 font-semibold w-fit whitespace-nowrap">PU HT</th>
      <th class="text-right py-2 px-3 font-semibold w-fit whitespace-nowrap">Total HT</th>
    </tr>
  </thead>

  <tbody>
    @foreach($bill->lines as $line)
    <tr class="border-b border-gray-200 text-gray-800 align-top">
      {{-- Produit --}}
      <td class="py-2 px-3 font-medium whitespace-nowrap">
        {{ $line->product->name }}
      </td>

      <td class="py-2 px-3 text-sm">
        @if($line->selectedOptions->isNotEmpty())
        <ul class="space-y-1">
          @foreach($line->selectedOptions as $option)
          <li class="text-gray-700">
            <div class="flex flex-wrap">
              {{-- Nom de l'option (ex: Maintenance annuelle :) --}}
              <span class="font-medium shrink-0">
                {{ $option->option?->name ?? 'Option' }} :
              </span>

              <span class="pl-2 flex-1 break-words">
                {{ $option->value }}
                @if($option->price > 0)
                <span class="text-gray-500 text-xs">
                  (+{{ number_format($option->price, 2, ',', ' ') }} €)
                </span>
                @endif
              </span>
            </div>
          </li>
          @endforeach
        </ul>
        @elseif($line->description)
        <div class="text-gray-700">{{ $line->description }}</div>
        @else
        <span class="text-gray-700 text-xs">—</span>
        @endif
      </td>

      <td class="text-right py-2 px-3 align-top w-fit whitespace-nowrap">
        {{ number_format($line->quantity, 2, ',', ' ') }}
      </td>

      <td class="text-right py-2 px-3 align-top w-fit whitespace-nowrap">
        {{ number_format($line->unit_price, 2, ',', ' ') }} €
      </td>

      <td class="text-right py-2 px-3 align-top font-semibold w-fit whitespace-nowrap">
        {{ number_format($line->total, 2, ',', ' ') }} €
      </td>
    </tr>
    @endforeach
  </tbody>
</table>