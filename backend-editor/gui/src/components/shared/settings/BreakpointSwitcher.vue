<template lang="">
  <div class="d-flex items-center text-center">
    <ul class="d-flex gap-1 m-0 p-0">
      <li
        v-for="val in breakpoints"
        :key="val"
        class="border cursor-pointer mb-0 py-1 px-2 rounded rounded-1"
        :class="{
          'bg-indigo-500 border-indigo-500 text-white': val === bp,
        }"
        @click="bp = val">
        {{ val }}
      </li>
    </ul>
  </div>
</template>
<script setup lang="ts">
import { useBreakpoints } from "../../../composables/useBreakpoints"
const props = defineProps({
  handle: String,
})

const { breakpoints, bp } = useBreakpoints(props.handle)
</script>
<style lang=""></style>
