<template id="bill-option-template">
  <fieldset class="border border-gray-700 rounded-lg p-4 bg-gray-800/40 backdrop-blur-sm">
    <legend class="text-sm font-semibold text-gray-300 mb-2" data-option-name></legend>
    <div data-option-values></div>
  </fieldset>
</template>

<template id="bill-option-value-template">
  <label class="flex items-center gap-2 text-sm text-gray-200 mb-1" data-option-value>
    <input
      type="{type}"
      name="{name}"
      value="{value}"
      data-price="{price}"
      class="accent-primary"
      {checked}>
    <span>{label}</span>
  </label>
</template>