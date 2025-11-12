<x-form.section title="Informations">
  <div class="grid grid-cols-2 gap-8">
    <x-form.input
      label="Durée de validité (jours)"
      name="due_date"
      type="number"
      min="1"
      :value="old('due_date', $bill?->issue_date && $bill?->due_date ? $bill->issue_date->diffInDays($bill->due_date) : 30)" />

    <x-form.input
      label="Remise globale (%)"
      name="discount_percentage"
      type="number"
      step="0.5"
      min="0"
      max="100"
      :value="old('discount_percentage', $bill?->discount_percentage ?? 0)" />
  </div>

  <div class="grid grid-cols-2 gap-8 mt-8">
    <div>
      <x-form.select
        label="Conditions de règlement"
        name="payment_terms"
        id="payment_terms"
        :options="collect($paymentTermsOptions)->mapWithKeys(fn($term) => [$term->value => $term->value === 'other' ? 'Autre' : $term->value])->toArray()"
        :selected="old('payment_terms', $bill?->payment_terms ?? $defaultPaymentTerms)"
        placeholder="Sélectionner une option" />

      <x-form.input
        label="Conditions personnalisées"
        class="mt-3 hidden"
        containerId="payment_terms_custom"
        name="payment_terms_custom"
        type="text"
        placeholder="Ex: 50% à la commande, 50% à la livraison"
        :value="old(
          'payment_terms_custom',
          !in_array($bill?->payment_terms ?? '', array_column($paymentTermsOptions, 'value'))
            ? $bill?->payment_terms
            : ''
        )" />
    </div>

    <div>
      <x-form.select
        label="Intérêts de retard"
        name="interest_rate"
        id="interest_rate"
        :options="collect($interestRateOptions)->mapWithKeys(fn($rate) => [$rate->value => $rate->value === 'other' ? 'Autre' : ($rate->value . '%')])->toArray()"
        :selected="old('interest_rate', (string) ($bill?->interest_rate ?? $defaultInterestRate))"
        placeholder="Sélectionner un taux" />

      <x-form.input
        label="Taux personnalisé (%)"
        class="mt-3 hidden"
        containerId="interest_rate_custom"
        name="interest_rate_custom"
        type="number"
        step="0.01"
        placeholder="Taux personnalisé"
        :value="old(
          'interest_rate_custom',
          !in_array((float) ($bill?->interest_rate ?? 0), collect($interestRateOptions)->pluck('value')->map(fn($v) => (float) $v)->toArray())
            ? $bill?->interest_rate
            : ''
        )" />
    </div>
  </div>
</x-form.section>