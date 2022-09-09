<template>
  <div class="d-flex align-items-center gap-1">
    <label class="text-600 d-flex gap-1 align-items-center position-relative"
      >{{ props.label }}
      <div class="d-flex align-items-center" v-if="props.responsive">
        <font-awesome-icon
          @click="showBreakpointSwitcher = !showBreakpointSwitcher"
          class="ms-1 text-500 popover-trigger"
          icon="mobile-alt" />
        <transition name="fade">
          <BreakpointSwitcher v-if="showBreakpointSwitcher" />
        </transition>
      </div>
    </label>
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
  </div>
</template>
<script setup lang="ts">
import { onMounted, ref } from "vue"
import * as bootstrap from "bootstrap"

const showBreakpointSwitcher = ref(false)

const props = defineProps({
  label: {
    type: String,
  },
  popover: {
    type: String,
  },
  responsive: {
    type: Boolean,
    default: false,
  },
})

onMounted(() => {
  const popoverTriggerList: any = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
  )
  const popoverList: any = [...popoverTriggerList].map(
    (popoverTriggerEl) =>
      new bootstrap.Popover(popoverTriggerEl, {
        placement: "right",
        trigger: "focus",
      })
  )
})
</script>
<style lang="scss">
.card-body label {
  font-size: 0.85em;
  text-transform: capitalize;
  line-height: 2;
}

.popover {
  z-index: 99999999 !important;
}
.popover-trigger {
  font-size: 0.9em;
}
</style>
