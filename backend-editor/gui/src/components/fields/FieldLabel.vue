<template>
  <span class="d-block pb-1 text-600">{{ props.label }}</span>
</template>
<script setup lang="ts">
const props = defineProps({
  label: {
    type: String,
  },
})
</script>
<style lang=""></style>
