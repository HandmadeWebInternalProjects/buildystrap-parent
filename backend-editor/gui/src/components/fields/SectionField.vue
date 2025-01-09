<template>
  <field-label
    v-if="config.label !== false"
    :label="config?.label !== undefined ? config.label : handle"
    :popover="config.popover" />
  <grid-section
    :section-index="1"
    :component="modelValue"
    :custom-settings="customSettings">
  </grid-section>
</template>

<script lang="ts" setup>
import { toRefs, onBeforeMount } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })
import { createModule } from "../../factories/modules/moduleFactory"

const { handle, config, modelValue } = toRefs(props)
const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
const section = createModule("Section")

const customSettings: { [key: string]: boolean } = {
  menu: false,
  add: false,
  clone: false,
  delete: false,
}

if (config?.value.customSettings) {
  // If custom setings are passed in with true values, remove them from the default settings
  Object.keys(config.value.customSettings).forEach((key) => {
    if (config.value.customSettings[key]) {
      delete customSettings[key]
    }
  })
}

onBeforeMount(() => {
  if (modelValue && !modelValue?.value) {
    modelValue.value = section
    // console.log({ section, model: modelValue })
    update(section)
  }
})
</script>
