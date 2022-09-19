<template>
  <div class="d-flex flex-column gap-4 pb-5">
    <bs-card label="Module Styles">
      <template v-slot:body>
        <module-styles
          breakpoint-handle="display"
          v-model="module_styles" />
      </template>
    </bs-card>

    <bs-card label="Display" breakpoint-handle="display">
      <template v-slot:body>
        <display-fields breakpoint-handle="display" v-model="display" />
      </template>
    </bs-card>

    <bs-card label="Sizing" breakpoint-handle="sizing">
      <template v-slot:body>
        <sizing-fields v-model="sizing" />
      </template>
    </bs-card>

    <bs-card label="Spacing" breakpoint-handle="margin-padding">
      <template v-slot:body>
        <box-model-fields
          breakpoint-handle="margin-padding"
          :config="{ label: 'Margin' }"
          v-model="margin" />
        <box-model-fields
          breakpoint-handle="margin-padding"
          :config="{ label: 'Padding' }"
          v-model="padding" />
      </template>
    </bs-card>

    <bs-card label="Background" breakpoint-handle="background">
      <template v-slot:body>
        <background-fields
          breakpoint-handle="background"
          :config="{ label: 'Background' }"
          v-model="background" />
      </template>
    </bs-card>

    <bs-card label="Typography" breakpoint-handle="typography">
      <template v-slot:body>
        <typography-fields
          breakpoint-handle="typography"
          v-model="typography" />
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

const inline = computed({
  get() {
    return props.modelValue || {}
  },
  set(val: any) {
    // Object.assign(props.modelValue, val)

    update(val)
  },
})

const module_styles = computed({
  get() {
    return inline.value.module_styles || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, module_styles: val }
  },
})

const display = computed({
  get() {
    return inline.value.display || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, display: val }
  },
})

const sizing = computed({
  get() {
    return inline.value || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, sizing: val }
  },
})

const margin = computed({
  get() {
    return inline.value.margin || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, margin: val }
  },
})

const padding = computed({
  get() {
    return inline.value.padding || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, padding: val }
  },
})

const background = computed({
  get() {
    return inline.value.background || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, background: val }
  },
})

const typography = computed({
  get() {
    return inline.value.typography || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, typography: val }
  },
})
</script>
<style lang=""></style>
