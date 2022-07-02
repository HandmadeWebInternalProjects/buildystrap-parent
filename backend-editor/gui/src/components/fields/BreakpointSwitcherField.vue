<template lang="">
  <ul class="d-flex gap-4">
    <li
      v-for="key in breakpoints"
      :key="key"
      class="border py-1 px-3 rounded"
      @click="updateBreakpoint(key)">
      {{ key }}
    </li>
  </ul>
</template>
<script setup lang="ts">
import { useBreakpoints } from "../../composables/useBreakpoints"

const { breakpoints, updateBreakpoint } = useBreakpoints()
</script>
<style lang=""></style>
