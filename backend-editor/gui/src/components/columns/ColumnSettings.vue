<template lang="">
  <bs-tabs>
    <bs-tab :uuid="`modules-${uuid}`" :active="true" name="modules">
      <select-field
        handle="modules"
        :config="{ label: 'Module Gap', options: ['1', '2', '3', '4', '5'] }"
        v-model="moduleGap" />
    </bs-tab>
    <bs-tab :uuid="`design-${uuid}`" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab :uuid="`attributes-${uuid}`" name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
    <bs-tab :uuid="`visibility-${uuid}`" name="visibility">
      <visibility-tab-settings v-model="config" />
    </bs-tab>
  </bs-tabs>
</template>

<script setup lang="ts">
import { generateID } from "@/utils/id"
import { ref, computed } from "vue"

const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})

const uuid = generateID()

const field = ref(props.field)

const inline = computed({
  get() {
    return field.value?.inline || {}
  },
  set(value) {
    field.value.inline = value
  },
})

const moduleGap = computed({
  get() {
    return field.value?.inline?.moduleGap || undefined
  },
  set(value) {
    inline.value = { ...inline.value, moduleGap: value }
  },
})

const attributes = computed({
  get() {
    return field.value?.attributes || {}
  },
  set(value) {
    field.value.attributes = value
  },
})

const config = computed({
  get() {
    return field.value?.config || {}
  },
  set(value) {
    field.value.config = value
  },
})
</script>
