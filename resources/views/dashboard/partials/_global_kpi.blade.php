<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
  <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
    <div class="p-3 rounded-full bg-muted/20 border border-border">
      <x-heroicon-o-users class="size-6 text-muted-foreground" />
    </div>
    <div>
      <p class="text-sm font-medium text-muted-foreground">Total clients</p>
      <p class="text-2xl font-bold text-foreground leading-tight">
        {{ $customerCount }}
      </p>
    </div>
  </div>

  <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
    <div class="p-3 rounded-full bg-muted/20 border border-border">
      <x-heroicon-o-document-text class="size-6 text-muted-foreground" />
    </div>
    <div>
      <p class="text-sm font-medium text-muted-foreground">Total devis</p>
      <p class="text-2xl font-bold text-foreground leading-tight">
        {{ $quotesCount }}
      </p>
    </div>
  </div>

  <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
    <div class="p-2.5 rounded-full bg-primary/10 border border-border">
      <x-heroicon-o-document-check class="size-6 text-primary" />
    </div>
    <div>
      <p class="text-sm font-medium text-muted-foreground">Total factures</p>
      <p class="text-2xl font-bold text-foreground leading-tight">
        {{ $invoicesCount }}
      </p>
    </div>
  </div>

  <div class="flex items-center gap-4 p-6 bg-card border border-border rounded-xl shadow-sm">
    <div class="p-3 rounded-full bg-warning/10 border border-border">
      <x-heroicon-o-currency-euro class="size-6 text-warning" />
    </div>
    <div>
      <p class="text-sm font-medium text-muted-foreground">Revenus {{ now()->year }}</p>
      <p class="text-2xl font-bold text-foreground leading-tight">
        {{ number_format($yearRevenue, 2, ',', ' ') }} €
      </p>
    </div>
  </div>
</div>