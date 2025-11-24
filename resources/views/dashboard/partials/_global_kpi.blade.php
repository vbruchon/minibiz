<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
  <x-kpi-card
    icon="heroicon-o-users"
    label="Total clients"
    :value="$customerCount" />


  <x-kpi-card
    icon="heroicon-o-document-text"
    label="Total devis"
    :value="$quotesCount" />


  <x-kpi-card
    icon="heroicon-o-document-check"
    label="Total factures"
    :value="$invoicesCount"
    iconBg="bg-primary/10"
    iconColor="text-primary" />


  <x-kpi-card
    icon="heroicon-o-currency-euro"
    label="Revenus {{ now()->year }}"
    :value="number_format($yearRevenue, 2, ',', ' ') . ' €'"
    iconBg="bg-warning/10"
    iconColor="text-warning" />

</div>