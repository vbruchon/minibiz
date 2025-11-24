<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>{{ $type }} #{{ $bill->number }}</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['DejaVu Sans', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    @page {
      size: A4;
      margin: 20mm;
    }

    body {
      font-family: 'DejaVu Sans', sans-serif !important;
      background: white;
      margin: 0;
      padding: 0;
    }
  </style>
</head>

<body class="flex flex-col gap-8 text-gray-800 w-[210mm] min-h-[297mm] mx-auto">
  <div class="flex justify-between">
    <div>
      <div class="flex items-center gap-3">
        <h2 class="text-2xl font-bold">
          {{ $type}} #{{ $bill->number }}
        </h2>
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
  @include('dashboard.bills.partials.show._entities', $bill)
  @include('dashboard.bills.partials.show._products_table', ['bill' => $bill, 'optionsHeader' => $optionsHeader])
  @include('dashboard.bills.partials.show._totals', $bill)

  @if($bill->isQuote())
  @include('dashboard.bills.partials.show._quote_conditions', $bill)
  @elseif($bill->isInvoice())
  @include('dashboard.bills.partials.show._invoice_conditions', $bill)
  @endif

  @if($bill->footer_note || $bill->notes)
  <div class="text-sm">
    <h4 class="font-semibold mb-2">Notes</h4>
    <p class="whitespace-pre-line">{{ $bill->footer_note }}</p>
    <p class="whitespace-pre-line">{{ $bill->notes }}</p>
  </div>
  @endif
</body>

</html>