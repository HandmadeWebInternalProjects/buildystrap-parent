<template>
  <div class="d-flex flex-column gap-4 pb-5">
    <div class="card border-0 bg-100">
      <div class="card-header pb-1 border-0 d-flex align-items-center">
        <field-label label="Margin / Padding" />
        <breakpoint-switcher-field handle="margin-padding" class="ms-auto" />
      </div>
      <div class="card-body border rounded d-flex flex-column gap-3">
        <box-model-field :config="{ label: 'Margin' }" v-model="margin" />
        <box-model-field :config="{ label: 'Padding' }" v-model="padding" />
      </div>
    </div>

    <background-field :config="{ label: 'Background' }" v-model="background" />
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
