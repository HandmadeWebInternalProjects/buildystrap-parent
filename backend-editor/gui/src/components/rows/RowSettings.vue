<template lang="">
  <bs-tabs>
    <bs-tab :active="true" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
    <bs-tab name="visibility">
      <visibility-tab-settings v-model="config" />
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

const component = ref(props.component)
const inline = ref(component.value?.inline || {})
const attributes = ref(component.value?.attributes || {})
const config = ref(component.value?.config || {})
</script>
<style lang=""></style>
