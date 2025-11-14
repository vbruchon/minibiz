<div class="flex justify-between">
  <div>
    <div class="flex items-center gap-3">
      <h2 class="text-2xl font-bold">
        {{ $type}} #{{ $bill->number }}
      </h2>
      <x-bill.status-badge :bill="$bill" isShow />
    </div>

    <div class="flex items-center gap-4 pt-1 text-sm text-gray-600 italic">
      <p>Émis le {{ $bill->issue_date->format('d/m/Y') }}</p>
      @if($bill->due_date && $bill->isQuote())
      <span>-</span>
      <p>Valide jusqu’au {{ $bill->due_date->format('d/m/Y') }}</p>
      @endif
    </div>
  </div>

  @if($bill->company->logo_path)
  <img src="{{ $bill->company->logo_path }}" alt="Logo {{ $bill->company->company_name }}" class="size-12 ">
  @endif
</div>