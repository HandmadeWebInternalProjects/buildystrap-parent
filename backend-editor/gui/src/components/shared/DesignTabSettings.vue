<template>
  <div class="d-flex flex-column gap-4 pb-5">
    <bs-card label="Margin / Padding" breakpoint-handle="margin-padding">
      <template v-slot:body>
        <box-model-field :config="{ label: 'Margin' }" v-model="margin" />
        <box-model-field :config="{ label: 'Padding' }" v-model="padding" />
      </template>
    </bs-card>

    <bs-card label="Background" breakpoint-handle="background">
      <template v-slot:body>
        <background-field
          breakpoint-handle="background"
          :config="{ label: 'Background' }"
          v-model="background" />
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
</script>
<style lang=""></style>
