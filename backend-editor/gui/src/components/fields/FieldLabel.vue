<template>
  <div class="d-flex align-items-center gap-1">
    <label class="text-600 text-capitalize d-flex gap-1 align-items-center position-relative"
      >{{ props.label }}
      <div
        class="label-responsive d-flex align-items-center"
        v-if="props.responsive">
        <font-awesome-icon
          @click="showBreakpointSwitcher = !showBreakpointSwitcher"
          class="ms-1 text-500"
          icon="mobile-alt" />
        <transition name="fade">
          <BreakpointSwitcher
            v-if="showBreakpointSwitcher"
            class="label-responsive__breakpoints shadow-sm" />
        </transition>
      </div>
    </label>
    <a
      v-if="popover"
      tabindex="0"
      role="button"
      data-bs-toggle="popover"
      data-bs-placement="right"
      data-bs-html="true"
      :data-bs-content="popover"
      class="popover-trigger__wrapper">
      <font-awesome-icon class="text-500" icon="question-circle" />
    </a>
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue"

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

// onMounted(() => {
//   const popoverTriggerList: any = document.querySelectorAll(
//     '[data-bs-toggle="popover"]'
//   )
//   const popoverList: any = [...popoverTriggerList].map(
//     (popoverTriggerEl) =>
//       new bootstrap.Popover(popoverTriggerEl, {
//         placement: "right",
//         html: true,
//       })
//   )
// })
</script>
<style lang="scss">
#app {
  label {
    line-height: 2;
  }
  .card-body label {
    font-size: 0.85em;
    text-transform: capitalize;
    line-height: 2;
  }
  .popover-trigger__wrapper {
    margin-left: 0.1rem;
  }

  .label-responsive {
    &__breakpoints {
      position: absolute;
      left: calc(100% + 5px);
      z-index: 2;

      ul {
        li {
          padding: 0 3px !important;
          background: white;
          line-height: 18px;
          text-transform: none;
        }
      }
    }
  }
}
.popover {
  z-index: 99999999 !important;
}
</style>
