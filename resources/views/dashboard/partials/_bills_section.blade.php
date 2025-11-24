<div class="space-y-8">

  <div class="flex flex-col sm:flex-row gap-4">
    <x-card title="Statistiques Devis" class="w-fit">

      <div class="space-y-3">
        <div class="flex items-center justify-between p-3 border border-border bg-muted/10 rounded-lg">
          <span class="text-foreground font-medium">Acceptés</span>
          <span class="font-semibold text-primary">{{ $acceptedQuotes }}</span>
        </div>

        <div class="flex items-center justify-between p-3 border border-border bg-muted/10 rounded-lg">
          <span class="text-foreground font-medium">Rejetés</span>
          <span class="font-semibold text-destructive">{{ $rejectedQuotes }}</span>
        </div>

        <div class="flex items-center justify-between p-3 border border-border bg-muted/10 rounded-lg">
          <span class="text-foreground font-medium">Convertis</span>
          <span class="font-semibold text-success">{{ $convertedQuotes }}</span>
        </div>
      </div>
    </x-card>

    <x-card title="Statistiques Factures" class="flex-1">
      <div class="space-y-3">
        <div class="flex items-center justify-between p-3 border border-border bg-muted/10 rounded-lg">
          <span class="text-foreground font-medium">Payées</span>
          <span class="font-semibold text-success">{{ $paidInvoices }}</span>
        </div>

        <div class="flex items-center justify-between p-3 border border-border bg-muted/10 rounded-lg">
          <span class="text-foreground font-medium">En retard</span>
          <span class="font-semibold text-warning">{{ $overdueInvoices }}</span>
        </div>

        <div class="flex items-center justify-between p-3 border border-border bg-muted/10 rounded-lg">
          <span class="text-foreground font-medium whitespace-nowrap">Revenus totaux</span>

          <span class="font-semibold text-primary whitespace-nowrap">
            {{ number_format($totalRevenue, 2, ',', ' ') }} €
          </span>
        </div>
      </div>
    </x-card>
  </div>
</div>