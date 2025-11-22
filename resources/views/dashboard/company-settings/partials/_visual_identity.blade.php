<x-form.section title="Identité visuelle" description="Ajoutez le logo de votre entreprise.">
  <div class="grid grid-cols-2 gap-8 items-start">

    {{-- Zone Drag & Drop --}}
    <div class="space-y-6">

      <div
        id="logo-dropzone"
        class="relative border-2 border-dashed border-muted-foreground/40 rounded-xl p-6 text-center cursor-pointer hover:border-primary transition">
        <input type="file" name="logo_file" id="logo_file" accept="image/*"
          class="absolute inset-0 opacity-0 cursor-pointer" />
        <p class="text-muted-foreground">Glissez votre logo ici ou cliquez pour importer</p>
        <p class="text-xs text-muted-foreground mt-1">Formats acceptés : PNG, JPG, SVG – max 2 Mo</p>
      </div>

      <x-form.input
        label="Ou indiquez une URL de logo"
        name="logo_path"
        id="logo_url"
        placeholder="https://exemple.com/logo.png"
        :value="old('logo_path', $company->logo_path ?? '')" />
    </div>

    {{-- Preview --}}
    <div id="logo-preview"
      class="bg-muted/20 border border-border rounded-xl p-4 flex items-center justify-center h-48">
      @if(!empty($company?->logo_path))
      <img src="{{ asset($company->logo_path) }}" alt="Logo actuel"
        class="h-32 object-contain transition-transform duration-300 hover:scale-105">
      @else
      <div class="text-muted-foreground text-sm italic text-center opacity-70">
        Aperçu du logo
      </div>
      @endif
    </div>
  </div>
</x-form.section>