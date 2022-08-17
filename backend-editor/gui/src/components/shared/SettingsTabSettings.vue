<template>
  <div class="d-flex flex-column gap-4">
    <text-field
      handle="id"
      :config="{ label: 'ID', placeholder: 'Enter the ID for the module' }"
      v-model="moduleId" />
    <text-field
      handle="class"
      :config="{
        label: 'Class',
        placeholder: 'Enter the classe(s) for the module',
      }"
      v-model="moduleClass" />
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
    return props.modelValue || {}
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

const moduleClass = computed({
  get() {
    return attributes.value.class || ""
  },
  set(val: any) {
    attributes.value = Object.assign(attributes.value, { class: val })
  },
})
</script>
<style lang=""></style>
