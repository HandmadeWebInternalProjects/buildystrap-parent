<template>
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

const customSettings = {
  menu: false,
  add: false,
  clone: false,
  delete: false,
}

const { handle, config, modelValue } = toRefs(props)
const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
const section = createModule("Section")

onBeforeMount(() => {
  if (modelValue && !modelValue?.value) {
    modelValue.value = section
    // console.log({ section, model: modelValue })
    update(section)
  }
})
</script>
