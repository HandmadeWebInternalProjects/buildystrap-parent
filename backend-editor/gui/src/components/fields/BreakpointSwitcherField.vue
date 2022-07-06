<template lang="">
  <div class="text-center">
    <field-label class="d-block pb-3" label="Screen Sizes" />
    <ul class="d-flex gap-4">
      <li
        v-for="key in breakpoints"
        :key="key"
        class="border cursor-pointer py-1 px-3 rounded"
        :class="{
          'bg-200': key === breakpoint,
        }"
        @click="updateBreakpoint(key)">
        {{ key }}
      </li>
    </ul>
  </div>
</template>
<script setup lang="ts">
import { useBreakpoints } from "../../composables/useBreakpoints"

const { breakpoints, breakpoint, updateBreakpoint } = useBreakpoints()
</script>
<style lang=""></style>
