<template>
  <field-label
    v-if="config.label !== false"
    :label="config?.label !== undefined ? config.label : handle"
    :popover="config.popover" />
  <grid-row
    :section-index="1"
    :component="modelValue"
    :custom-settings="customSettings">
  </grid-row>
</template>

<script lang="ts" setup>
import { toRefs, onBeforeMount } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })
import { createModule } from "../../factories/modules/moduleFactory"

const customSettings = {
  menu: false,
  add: false,
  clone: false,
  delete: false,
}

const { handle, config, modelValue } = toRefs(props)
const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
const row = createModule("Row")

onBeforeMount(() => {
  if (modelValue && !modelValue?.value) {
    modelValue.value = row
    // console.log({ row, model: modelValue })
    update(row)
  }
})
</script>
