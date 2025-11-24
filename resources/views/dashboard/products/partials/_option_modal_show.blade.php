<x-modal id="optionShowModal-{{ $option->id }}">
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">{{ $option->name }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <x-detail-field label="Nom" :value="$option->name" />
      <x-detail-field label="Type" :value="ucfirst($option->type)" />
    </div>

    @if(in_array($option->type, ['text','number']))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <x-detail-field label="Valeur par défault" :value="$option->pivot->default_value ?? '-'" />
      <x-detail-field label="Prix par défault (€)" :value="number_format($option->pivot->default_price ?? 0, 2)" />
      <x-detail-field label="Attaché par défault"
        :value="$option->pivot->is_default_attached ? 'Oui' : 'Non'" />
    </div>
    @endif

    @if($option->values->count())
    <div class="space-y-4">
      <h3 class="text-lg font-semibold">Valeurs</h3>

      @foreach($option->values as $value)
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-muted/10 border border-border rounded-xl">
        <x-detail-field label="Valeur" :value="$value->value" />
        <x-detail-field label="Prix (€)" :value="number_format($value->price ?? 0, 2)" />
        <x-detail-field label="Défault" :value="$value->is_default ? 'Yes' : 'No'" />
      </div>
      @endforeach
    </div>
    @endif

    <div class="flex justify-end">
      <x-button
        variant="info"
        size="sm"
        data-modal-target="productOptionModal-{{ $option->id }}">
        Modifier
      </x-button>
    </div>
  </div>
</x-modal>