<div class="flex items-start justify-between gap-20">
  <x-bill.entity-details
    :entity="$bill->company"
    title="Émetteur" />

  <x-bill.entity-details
    :entity="$bill->customer"
    title="Destinataire" />
</div>