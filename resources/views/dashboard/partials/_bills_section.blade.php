<div class="space-y-8">
  <div class="flex flex-col sm:flex-row gap-4">
    <div class="border border-gray-700 bg-gray-900/70 rounded-xl p-6 flex-1">
      <h2 class="text-lg font-semibold text-gray-300 mb-4">Statistiques Devis</h2>

      <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-gray-900/40 border border-gray-700 rounded-lg">
          <span class="text-gray-300">Acceptés</span>
          <span class="font-semibold text-primary">{{ $acceptedQuotes }}</span>
        </div>

        <div class="flex items-center justify-between p-3 bg-gray-900/40 border border-gray-700 rounded-lg">
          <span class="text-gray-300">Rejetés</span>
          <span class="font-semibold text-red-500">{{ $rejectedQuotes }}</span>
        </div>

        <div class="flex items-center justify-between p-3 bg-gray-900/40 border border-gray-700 rounded-lg">
          <span class="text-gray-300">Convertis</span>
          <span class="font-semibold text-green-500">{{ $convertedQuotes }}</span>
        </div>
      </div>
    </div>

    <div class="border border-gray-700 bg-gray-900/70 rounded-xl py-6 px-4 w-fit">
      <h2 class="text-lg font-semibold text-gray-300 mb-4">Statistiques Factures</h2>

      <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-gray-900/40 border border-gray-700 rounded-lg">
          <span class="text-gray-300">Payées</span>
          <span class="font-semibold text-green-400">{{ $paidInvoices }}</span>
        </div>

        <div class="flex items-center justify-between p-3 bg-gray-900/40 border border-gray-700 rounded-lg">
          <span class="text-gray-300">En retard</span>
          <span class="font-semibold text-orange-400">{{ $overdueInvoices }}</span>
        </div>

        <div class="flex items-center justify-between p-3 bg-gray-900/40 border border-gray-700 rounded-lg">
          <span class="text-gray-300 w-32 whitespace-nowrap">Revenus totaux</span>

          <span class="font-semibold text-primary whitespace-nowrap">
            {{ number_format($totalRevenue, 2, ',', ' ') }} €
          </span>
        </div>

      </div>
    </div>

  </div>

</div>