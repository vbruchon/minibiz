<x-form.section title="Destinataire">
  <x-form.select
    name="customer_id"
    :options="$customers->pluck('company_name', 'id')"
    placeholder="Sélectionner un client"
    required />
</x-form.section>