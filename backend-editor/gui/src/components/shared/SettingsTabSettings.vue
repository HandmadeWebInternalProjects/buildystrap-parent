<template>
  <div class="d-flex flex-column gap-4">
    <bs-card label="ID">
      <template v-slot:body>
        <text-field
          handle="id"
          :config="{
            label: false,
            placeholder: 'Enter the ID for the module',
          }"
          v-model="moduleId" />
      </template>
    </bs-card>
    <bs-card label="Class">
      <template v-slot:body>
        <text-field
          handle="class"
          :config="{
            label: false,
            placeholder: 'Enter the class or classes for the module',
          }"
          v-model="moduleClass" />
      </template>
    </bs-card>
    <bs-card label="Data Attributes">
      <template v-slot:body>
        <replicator-field
          handle="data-atts"
          :fields="{
            key: {
              handle: 'key',
              type: 'text-field',
              config: {
                label: 'Key',
                placeholder: 'Enter the key for the data attribute',
              },
            },
            value: {
              handle: 'value',
              type: 'text-field',
              config: {
                label: 'Value',
                placeholder: 'Enter the value for the data attribute',
              },
            },
          }"
          :config="{
            label: false,
            preview: 'key',
          }"
          v-model="dataAtts" />
      </template>
    </bs-card>
  </div>
</template>
<script setup lang="ts">
import { computed } from "vue"
import { useFieldType } from "../fields/useFieldType"
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})
const emit = defineEmits(["update:modelValue"])
const { update } = useFieldType(emit)

const attributes = computed({
  get() {
    const attributes = props?.modelValue || {}

    if (Array.isArray(attributes)) {
      return {}
    }

    return attributes
  },
  set(val: any) {
    update(val)
  },
})

const moduleId = computed({
  get() {
    return attributes.value.id || ""
  },
  set(val: any) {
    attributes.value = Object.assign(attributes.value, { id: val })
  },
})

const dataAtts = computed({
  get() {
    return attributes.value.dataAtts || []
  },
  set(val: any) {
    attributes.value = Object.assign(attributes.value, { dataAtts: val })
  },
})

const moduleClass = computed({
  get() {
    console.log(attributes)
    return attributes.value.class || ""
  },
  set(val: any) {
    console.log(val)
    attributes.value = Object.assign(attributes.value, { class: val })
  },
})
</script>
<style lang=""></style>
