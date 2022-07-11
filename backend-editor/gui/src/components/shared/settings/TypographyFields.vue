<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { useBreakpoints } from "../../../composables/useBreakpoints"

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
  "font-size": props.modelValue["font-size"] || {},
  "text-align": props.modelValue["text-align"] || {},
})

watch(typography, (val: any) => {
  update(filterOutEmptyValues(val))
})
</script>

<template>
  <field-group>
    <select-field
      class="w-100"
      handle="font-family"
      :placeholder="responsivePlaceholder(typography, 'font-family', bp)"
      :config="{
        label: 'Font Family',
        options: ['serif', 'sans-serif'],
        disabled: bp !== 'xs',
        taggable: true,
      }"
      v-model="typography['font-family'][bp]" />
    <select-field
      class="w-100"
      handle="text-colour"
      :placeholder="responsivePlaceholder(typography, 'color', bp)"
      :config="{
        label: 'Text Colour',
        options: ['Primary', 'Secondary', 'Tertiary'],
        taggable: true,
      }"
      v-model="typography.color[bp]" />
    <div class="d-flex gap-4">
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="size"
        :placeholder="responsivePlaceholder(typography, 'font-size', bp)"
        :config="{
          label: 'Font Size',
          options: ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
          taggable: true,
        }"
        v-model="typography['font-size'][bp]" />
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="text-align"
        :placeholder="responsivePlaceholder(typography, 'text-align', bp)"
        :config="{
          label: 'Text Align',
          options: ['left', 'center', 'right'],
        }"
        v-model="typography['text-align'][bp]" />
    </div>
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
