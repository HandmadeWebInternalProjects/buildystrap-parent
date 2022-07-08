<template>
  <div>
    <field-label :label="config?.label" />
    <ul class="d-flex gap-4 m-0 p-0">
      <li
        class="flex-grow-1"
        v-for="(dir, key) in values"
        :key="`box-model-${key}-${breakpoint}`">
        <select-field
          handle="box_model_top"
          type="text"
          :placeholder="hasPlaceholder(key)"
          :config="{
            label: key,
            options: options,
            taggable: true,
          }"
          v-model="dir[breakpoint]" />
      </li>
    </ul>
  </div>
</template>
<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../fields/useFieldType"
import { useBreakpoints } from "../../composables/useBreakpoints"
const { breakpoint, breakpoints } = useBreakpoints()

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  config: {
    type: Object,
    required: false,
  },
})

const emit = defineEmits(["update:modelValue"])

const { update, filterOutEmptyValues } = useFieldType(emit)

const values: any = reactive(
  Object.assign(
    {
      top: {},
      right: {},
      bottom: {},
      left: {},
    },
    props.modelValue
  )
)

const hasPlaceholder = (key: string | number) => {
  // check if value has the key on this breakpoint
  if (
    values[key][breakpoint.value] !== undefined &&
    values[key][breakpoint.value]
  )
    return ""

  let placeholder = ""
  let currentBPIndex = breakpoints.indexOf(breakpoint.value)

  breakpoints.forEach((bp, i) => {
    if (i > currentBPIndex) return
    if (values[key][bp] !== undefined) {
      return (placeholder = values[key][bp])
    }
  })

  return placeholder
}

// array of 10 numbers
const options = Array.from({ length: 10 }, (_, i) => i)

watch(values, (val: any) => {
  update(filterOutEmptyValues(val))
})
</script>
<style lang=""></style>
