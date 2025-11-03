<x-form.section title="Informations">
  <div class="grid grid-cols-2 gap-8 ">
    <x-form.input label="Durée de validité (jours)" name="due_date" type="number" min="1" />
    <x-form.input label="Remise globale (%)" name="discount" type="number" step="0.5" min="0" max="100" value="0" />
  </div>
</x-form.section>