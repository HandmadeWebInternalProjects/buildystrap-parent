<template>
  <div>
    <box-model-field v-model="margin" />
    <box-model-field v-model="padding" />
  </div>
</template>
<script setup lang="ts">
import { computed, ref } from "vue"
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
</script>
<style lang=""></style>
