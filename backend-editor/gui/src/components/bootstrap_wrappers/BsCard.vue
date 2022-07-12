<template lang="">
  <div class="card border-0 bg-100">
    <div class="card-header pb-1 border-0 d-flex align-items-center">
      <field-label :label="label" />
      <breakpoint-switcher
        v-if="breakpointHandle"
        :handle="breakpointHandle"
        class="ms-auto" />
    </div>
    <div class="card-body rounded-bottom d-flex flex-column gap-3">
      <slot name="body"></slot>
    </div>
  </div>
</template>
<script setup lang="ts">
const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  breakpointHandle: {
    type: String,
    required: false,
  },
})
</script>
<style lang=""></style>
