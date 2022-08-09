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
  field: {
    type: Object,
    required: true,
  },
})

const field = ref(props.field)
const inline = ref(field.value?.inline || {})
const attributes = ref(field.value?.attributes || {})
const config = ref(field.value?.config || {})
</script>
