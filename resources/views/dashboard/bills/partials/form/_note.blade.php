<x-form.section title="Note interne" :separator="false">
  <x-form.textarea
    label="Informations complémentaires"
    name="footer_note"
    rows="3"
    placeholder="Conditions, remarques ou mentions pour ce devis...">{{ old('footer_note', $bill->footer_note ?? '') }}</x-form.textarea>
</x-form.section>