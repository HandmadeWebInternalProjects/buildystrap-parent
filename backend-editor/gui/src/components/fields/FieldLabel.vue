<template>
  <label class="text-600">{{ props.label }}</label>
  <a
    v-if="popover"
    tabindex="0"
    role="button"
    data-bs-toggle="popover"
    data-bs-trigger="focus"
    title="Dismissible popover"
    :data-bs-content="popover"
    ><font-awesome-icon
      class="ms-1 text-500 popover-trigger"
      icon="question-circle" />
  </a>
</template>
<script setup lang="ts">
import { onMounted } from "vue"
import * as bootstrap from "bootstrap"
const props = defineProps({
  label: {
    type: String,
  },
  popover: {
    type: String,
  },
})

onMounted(() => {
  const popoverTriggerList = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
  )
  const popoverList = [...popoverTriggerList].map(
    (popoverTriggerEl) =>
      new bootstrap.Popover(popoverTriggerEl, {
        placement: "right",
        trigger: "focus",
      })
  )
})
</script>
<style lang="scss">
.popover {
  z-index: 99999999 !important;
}

.popover-trigger {
  font-size: 0.9em;
}
</style>
