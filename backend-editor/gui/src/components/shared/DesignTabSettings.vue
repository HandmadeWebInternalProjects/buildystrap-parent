<template>
  <div class="d-flex flex-column gap-4 pb-5">
    <bs-card label="Sizing" breakpoint-handle="sizing">
      <template v-slot:body>
        <sizing-fields v-model="sizing" />
      </template>
    </bs-card>

    <bs-card label="Spacing" breakpoint-handle="margin-padding">
      <template v-slot:body>
        <box-model-fields :config="{ label: 'Margin' }" v-model="margin" />
        <box-model-fields :config="{ label: 'Padding' }" v-model="padding" />
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
    update(val)
  },
})

const margin = computed({
  get() {
    return inline.value.margin || {}
  },
  set(val: any) {
    inline.value.margin = val
  },
})

const padding = computed({
  get() {
    return inline.value.padding || {}
  },
  set(val: any) {
    inline.value.padding = val
  },
})

const background = computed({
  get() {
    return inline.value.background || {}
  },
  set(val: any) {
    inline.value.background = val
  },
})

const sizing = computed({
  get() {
    return inline.value || {}
  },
  set(val: any) {
    inline.value = { ...inline.value, ...val }
  },
})

const typography = computed({
  get() {
    return inline.value.typography || {}
  },
  set(val: any) {
    inline.value.typography = val
  },
})
</script>
<style lang=""></style>
