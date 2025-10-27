@props(['company' => null, 'initialType' => 'Société'])

<x-form.section title="Informations légales" :separator="false">
  <div class="grid grid-cols-2 gap-6">
    {{-- Type d’activité --}}
    <x-form.select
      label="Type d’activité"
      name="business_type"
      :options="['company' => 'Société', 'auto' => 'Auto-entrepreneur']"
      required
      :selected="$initialType" />

    <x-form.input label="Numéro SIREN" name="siren" optional
      :value="old('siren', $company->siren ?? '')" />

    <x-form.input label="Numéro SIRET" name="siret" required
      :value="old('siret', $company->siret ?? '')" />

    {{-- TVA --}}
    <div id="vat" class="block">
      <x-form.input label="Numéro de TVA intracommunautaire" name="vat_number" optional
        :value="old('vat_number', $company->vat_number ?? '')" />
    </div>

    {{-- Devise --}}
    <x-form.input label="Devise" name="currency" placeholder="EUR"
      :value="old('currency', $company->currency ?? 'EUR')" />

    {{-- Taux de TVA par défaut --}}
    <div id="tax-rate" class="block">
      <x-form.input
        label="Taux de TVA par défaut (%)"
        name="default_tax_rate"
        type="number"
        step="0.01"
        :value="old('default_tax_rate', $company->default_tax_rate ?? 20.00)" />
    </div>
  </div>

  {{-- Footer note --}}
  <x-form.textarea
    label="Mention de bas de page (affichée sur les devis et factures)"
    name="footer_note"
    rows="3"
    optional>{{ old('footer_note', $company->footer_note ?? '') }}</x-form.textarea>
</x-form.section>