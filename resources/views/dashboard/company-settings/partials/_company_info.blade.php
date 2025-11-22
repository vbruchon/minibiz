<x-form.section title="Informations de l’entreprise">
  <div class="grid grid-cols-2 gap-6">
    <x-form.input label="Nom de l’entreprise" name="company_name" required
      :value="old('company_name', $company->company_name ?? '')" />

    <x-form.input label="Adresse e-mail de l’entreprise" name="company_email" type="email" required
      :value="old('company_email', $company->company_email ?? '')" />

    <x-form.input label="Numéro de téléphone" name="company_phone" optional
      :value="old('company_phone', $company->company_phone ?? '')" />

    <x-form.input label="Site web" name="website" optional
      :value="old('website', $company->website ?? '')" />
  </div>

  <div class="grid grid-cols-2 gap-6">
    <x-form.input label="Adresse – ligne 1" name="address_line1" required
      :value="old('address_line1', $company->address_line1 ?? '')" />

    <x-form.input label="Adresse – ligne 2" name="address_line2" optional
      :value="old('address_line2', $company->address_line2 ?? '')" />
  </div>

  <div class="grid grid-cols-3 gap-6">
    <x-form.input label="Code postal" name="postal_code" required
      :value="old('postal_code', $company->postal_code ?? '')" />

    <x-form.input label="Ville" name="city" required
      :value="old('city', $company->city ?? '')" />

    <x-form.input label="Pays" name="country" required
      :value="old('country', $company->country ?? '')" />
  </div>
</x-form.section>