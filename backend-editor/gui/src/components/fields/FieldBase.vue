<template>
  <div v-if="showField()">
    <component
      :type="field.type"
      :module-type="moduleType"
      :config="field.config || {}"
      :key="handle"
      :handle="handle"
      :meta="meta"
      :uuid="uuid"
      v-model="value[handle]"
      :is="field.type"
      @update-meta="updateMeta" />
  </div>
</template>

<script lang="ts" setup>
import Validator from "../../field-conditions/Validator"
import { useFieldType, commonProps } from "./useFieldType"
import { computed } from "vue"

const props = defineProps({
  ...commonProps,
  field: {
    type: Object,
    required: true,
  },
  moduleType: {
    type: String,
    required: false,
  },
  handle: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(["updateMeta", "update:modelValue"])

const { update } = useFieldType(emit)

const value = computed({
  get() {
    return props?.modelValue || {}
  },
  set(val) {
    update(val)
  },
})

const showField = () => {
  if (!props.field.config) return true
  const validator = new Validator(props?.field?.config, value.value, {}, "base")
  return validator.passesConditions()
}

const updateMeta = (meta: any) => {
  emit("updateMeta", meta)
}
</script>

<style></style>
