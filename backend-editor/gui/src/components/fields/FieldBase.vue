<template>
  <div v-if="showField()" :class="`${field.config?.class ?? 'g-col-12'}`">
    <component
      :type="field.type"
      :module-type="moduleType"
      :config="field.config || {}"
      :key="handle"
      :handle="handle"
      :meta="meta"
      :uuid="uuid"
      :placeholder="
        config?.responsive && responsivePlaceholder(value, handle, bp)
      "
      :values="value"
      v-model="fieldValue"
      :is="field.type"
      @update-meta="updateMeta" />
  </div>
</template>

<script lang="ts" setup>
import Validator from "../../field-conditions/Validator"
import { useFieldType, commonProps } from "./useFieldType"
import { computed } from "vue"

import { useBreakpoints } from "../../composables/useBreakpoints"
const { bp } = useBreakpoints("global")

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

const { update, responsivePlaceholder } = useFieldType(emit)

const value = computed({
  get() {
    return props?.modelValue || {}
  },
  set(val) {
    console.log({ val })
    update(val)
  },
})

const fieldValue = computed({
  get() {
    return props.field.config?.responsive
      ? value.value[props.handle]?.[bp.value] || undefined
      : value.value[props.handle]
  },
  set(val) {
    props.field.config?.responsive
      ? ((value.value[props.handle]
          ? value.value[props.handle]
          : (value.value[props.handle] = {}))[bp.value] = val)
      : (value.value[props.handle] = val)
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
