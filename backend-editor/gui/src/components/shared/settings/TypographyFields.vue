<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { useBreakpoints } from "../../../composables/useBreakpoints"
import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { getThemeColours, getTypography, getFontSize } = useBuilderOptions()

const props = defineProps({
  config: {
    type: Object,
    required: false,
  },
  breakpointHandle: {
    type: String,
    required: false,
  },
  modelValue: { type: Object, required: true },
})

const { bp } = useBreakpoints(props.breakpointHandle)

const emit = defineEmits(["update:modelValue"])
const { update, filterOutEmptyValues, responsivePlaceholder } =
  useFieldType(emit)

const typography: any = reactive({
  color: props.modelValue.color || {},
  "font-family": props.modelValue["font-family"] || {},
  "font-weight": props.modelValue["font-weight"] || {},
  "font-size": props.modelValue["font-size"] || {},
  "line-height": props.modelValue["line-height"] || {},
  "text-align": props.modelValue["text-align"] || {},
})

watch(typography, (val: any) => {
  update(filterOutEmptyValues(val))
})
</script>

<template>
  <field-group>
    <select-field
      class="g-col-12 w-100"
      handle="text-colour"
      :placeholder="responsivePlaceholder(typography, 'color', bp)"
      :config="{
        label: 'Text Colour',
        options: getThemeColours(),
        taggable: true,
      }"
      v-model="typography.color[bp]" />
    <div class="g-col-12 d-flex gap-3">
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="font-family"
        :placeholder="responsivePlaceholder(typography, 'font-family', bp)"
        :config="{
          label: 'Font Family',
          options: getTypography(),
          disabled: bp !== 'xs',
          taggable: true,
        }"
        v-model="typography['font-family'][bp]" />
      <select-field
        class="g-col-12 flex-grow-1 flex-basis-0"
        handle="font-weight"
        :placeholder="responsivePlaceholder(typography, 'font-weight', bp)"
        :config="{
          label: 'Font Weight',
          options: ['normal', 'bold'],
          disabled: bp !== 'xs',
          taggable: true,
        }"
        v-model="typography['font-weight'][bp]" />
    </div>
    <div class="g-col-12 d-flex gap-3">
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="size"
        :placeholder="responsivePlaceholder(typography, 'font-size', bp)"
        :config="{
          label: 'Font Size',
          options: getFontSize(),
          taggable: true,
        }"
        v-model="typography['font-size'][bp]" />
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="text-align"
        :placeholder="responsivePlaceholder(typography, 'text-align', bp)"
        :config="{
          label: 'Text Align',
          options: [
            { value: 'start', label: 'Left' },
            { value: 'center', label: 'Center' },
            { value: 'end', label: 'Right' },
          ],
        }"
        v-model="typography['text-align'][bp]" />

      <select-field
        class="g-col-12 flex-grow-1 flex-basis-0"
        handle="line-height"
        :placeholder="responsivePlaceholder(typography, 'line-height', bp)"
        :config="{
          label: 'Line Height',
          options: ['1', 'sm', 'base', 'lg'],
        }"
        v-model="typography['line-height'][bp]" />
    </div>
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
