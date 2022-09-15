<template>
  <div>
    <select-field
      v-if="moduleStyles.length"
      handle="box_model_top"
      type="text"
      :config="{
        label: false,
        options: moduleStyles,
        multiple: true,
      }"
      v-model="value" />
  </div>
</template>
<script lang="ts" setup>
import { computed, inject } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { storeToRefs } from "pinia"
import { useBuilderStore } from "@/stores/builder"

const { getModuleStyles } = storeToRefs(useBuilderStore())

type ModuleStyle = {
  module_name: string
  styles: {
    [key: string]: any
  }[]
}

// inject component
const component = inject<{ [key: string]: any }>("component")
console.log(component.type)

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(["update:modelValue"])

const { update } = useFieldType(emit)

const moduleStyles = computed((): any => {
  const sharedStyles =
    getModuleStyles?.value?.find(
      (moduleStyle: ModuleStyle) => moduleStyle.module_name === "shared-module"
    ) || []

  const hasModuleStyles =
    getModuleStyles?.value.find(
      (moduleStyle: ModuleStyle) => moduleStyle.module_name === component?.type
    ) || []

  console.log({ hasModuleStyles })

  const combined_styles = [
    ...(hasModuleStyles?.styles || []),
    ...(sharedStyles?.styles || []),
  ]

  return combined_styles ? combined_styles : null
})

const value = computed({
  get() {
    return Object.keys(props?.modelValue).length ? props?.modelValue : null
  },
  set(val) {
    update(val)
  },
})
</script>
<style lang=""></style>
