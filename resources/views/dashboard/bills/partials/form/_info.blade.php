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
</x-form.section>