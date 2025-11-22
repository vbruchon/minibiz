@props([
'entity',
'title' => '',
])

<div class="w-1/2">
  <h3 class="text-lg mb-2 italic font-light text-black">{{ $title }}</h3>

  <h4 class="font-semibold text-lg mb-1 text-black">
    {{ $entity->company_name }}
  </h4>

  <div class="flex flex-col gap-1.5 text-sm leading-tight">
    <div class="flex items-start gap-2">
      <p class="min-w-[85px] font-medium ">Adresse :</p>
      <p class="whitespace-pre-line">{{ $entity->full_address }}</p>
    </div>

    <div class="flex items-center gap-2">
      <p class="min-w-[85px] font-medium ">Email :</p>
      <p>{{ $entity->company_email }}</p>
    </div>

    @if($entity->company_phone)
    <div class="flex items-center gap-2">
      <p class="min-w-[85px] font-medium ">Téléphone :</p>
      <p>{{ $entity->company_phone }}</p>
    </div>
    @endif

    @if($entity->website)
    <div class="flex items-center gap-2">
      <p class="min-w-[85px] font-medium ">Site web :</p>
      <p class="max-w-[200px] truncate" title="{{ $entity->website }}">
        <a href="{{ $entity->website }}" target="_blank" class="text-blue-600 hover:underline">
          {{ parse_url($entity->website, PHP_URL_HOST) ?? $entity->website }}
        </a>
      </p>
    </div>
    @endif

    <div class="mt-2 space-y-0.5">
      @if($entity->siren)
      <div class="flex items-center gap-2">
        <p class="min-w-[85px]  font-medium">SIREN :</p>
        <p>{{ $entity->siren }}</p>
      </div>
      @endif

      @if($entity->siret)
      <div class="flex items-center gap-2">
        <p class="min-w-[85px]  font-medium">SIRET :</p>
        <p>{{ $entity->siret }}</p>
      </div>
      @endif

      @if($entity->ape_code)
      <div class="flex items-center gap-2">
        <p class="min-w-[85px]  font-medium">Code APE :</p>
        <p>{{ $entity->ape_code }}</p>
      </div>
      @endif

      @if($entity->vat_number)
      <div class="flex items-center gap-2">
        <p class="min-w-[85px]  font-medium">TVA :</p>
        <p>{{ $entity->vat_number }}</p>
      </div>
      @endif
    </div>
  </div>
</div>