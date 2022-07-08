<template lang="">
  <div class="text-center">
    <ul class="d-flex gap-1 m-0 p-0">
      <li
        v-for="val in breakpoints"
        :key="val"
        class="border cursor-pointer py-1 px-2 rounded"
        :class="{
          'bg-200': val === bp,
        }"
        @click="bp = val">
        {{ val }}
      </li>
    </ul>
  </div>
</template>
<script setup lang="ts">
import { useBreakpoints } from "../../composables/useBreakpoints"
const props = defineProps({
  handle: String,
})

const { breakpoints, bp } = useBreakpoints(props.handle)
</script>
<style lang=""></style>
