<x-form.section title="Destinataire">
  <x-form.select
    name="customer_id"
    :options="$customers->pluck('company_name', 'id')"
    placeholder="Sélectionner un client"
    :selected="old('customer_id', $bill->customer_id ?? null)"
    required />

</x-form.section>