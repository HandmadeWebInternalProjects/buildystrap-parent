<template lang="">
  <bs-tabs>
    <bs-tab :active="true" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
  </bs-tabs>
</template>

<script setup lang="ts">
import { ref } from "vue"
const props = defineProps({
  type: {
    type: String,
    required: true,
  },
  component: {
    type: Object,
    required: true,
  },
})

const inline = ref(props.component.value?.inline || {})
const attributes = ref(props.component.value?.attributes || {})
</script>
<style lang=""></style>
