<meta name="prices" content='@json($prices)'>
<meta name="options" content='@json($productOptions)'>
<meta name="has-vat" content='@json($hasVAT)'>
<meta name="vat-rate" content='@json($vatRate)'>

@if(isset($bill) && $bill?->formatted_lines)
<meta name="bill-lines" content='@json($bill->formatted_lines)'>
@endif