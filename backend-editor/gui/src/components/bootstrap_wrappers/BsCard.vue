<template lang="">
  <div class="card border-0 bg-100">
    <div
      v-if="label !== false"
      class="card-header border-0 d-flex align-items-center">
      <field-label :label="label" :popover="popover" />
      <breakpoint-switcher
        v-if="breakpointHandle"
        :handle="breakpointHandle"
        class="ms-auto" />
    </div>
    <div
      class="card-body rounded-bottom d-flex flex-column"
      :class="`gap-${gap}`">
      <slot name="body"></slot>
    </div>
  </div>
</template>
<script setup lang="ts">
const props = defineProps({
  label: {
    type: [String, Boolean],
    required: true,
  },
  popover: {
    type: String,
    required: false,
    default: "",
  },
  breakpointHandle: {
    type: String,
    required: false,
  },
  gap: {
    type: String,
    required: false,
    default: "3",
  },
})
</script>
<style lang="scss">
.card {
  max-width: none;
  margin: 0;
  padding: 0;
}
.card-header {
  min-height: 45px;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
.card-body {
  .sub-label {
    label {
      font-size: 0.7em;
    }
  }
}
</style>
