<template>
  <div class="grid row" :class="`gap-${gap}`">
    <slot />
  </div>
</template>
<script lang="ts" setup>
const props = defineProps({
  gap: {
    type: String,
    required: false,
    default: "3",
  },
})
</script>
<style lang=""></style>
