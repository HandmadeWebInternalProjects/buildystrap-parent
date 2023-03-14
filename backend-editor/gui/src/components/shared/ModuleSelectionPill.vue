<script setup lang="ts">
import { slugToStr } from "@/utils/helpers"

const props = defineProps({
  moduleItem: {
    type: Object,
    required: true,
  },
  handle: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <div class="position-relative">
    <div
      class="border bg-700 text-white cursor-pointer transition-all scale-md-hover w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm"
      style="
        transform: perspective(1px) translateZ(0);
        backface-visibility: hidden;
      ">
      <i
        v-if="moduleItem?.icon"
        class="inline-flex w-10 cursor-pointer pulse"
        :class="[moduleItem.icon]"
        style="width: 1rem"
        aria-controls="offcanvasRight"></i>
      <span class="block pl-2">
        {{ moduleItem?.title ? moduleItem.title : slugToStr(handle) }}
      </span>
    </div>
  </div>
</template>

<style lang="scss">
.preview-dialog {
  position: absolute;
  left: 0;
  right: unset;
  transform: translateX(-112%);
}
</style>
