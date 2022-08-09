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

const display: any = reactive({
  position: props.modelValue["position"] || {},
  attributes: props.modelValue["attributes"] || {},
  property: props.modelValue["property"] || {},
  "flex-direction": props.modelValue["flex-direction"] || {},
  "flex-wrap": props.modelValue["flex-wrap"] || {},
  "justify-content": props.modelValue["justify-content"] || {},
  "align-items": props.modelValue["align-items"] || {},
  "align-self": props.modelValue["align-self"] || {},
  "align-content": props.modelValue["align-content"] || {},
  "grid-template-rows": props.modelValue["grid-template-rows"] || {},
  "grid-template-columns": props.modelValue["grid-template-columns"] || {},
  "column-gap": props.modelValue["column-gap"] || {},
  "row-gap": props.modelValue["row-gap"] || {},
  order: props.modelValue["order"] || {},
})

const options = Array.from({ length: 13 }, (_, i) => i)

watch(display, (val: any) => {
  update(filterOutEmptyValues(val))
})
</script>

<template>
  <field-group>
    <select-field
      class="w-100"
      handle="position"
      :placeholder="responsivePlaceholder(display, 'position', bp)"
      :config="{
        label: 'Position',
        options: [
          { value: 'relative', label: 'Relative' },
          { value: 'absolute', label: 'Absolute' },
          { value: 'fixed', label: 'Fixed' },
          { value: 'sticky', label: 'Sticky' },
          { value: 'static', label: 'Static' },
        ],
        popover: 'Attributes have no effect on non-positioned elements.',
      }"
      v-model="display.position[bp]" />
    <box-model-fields
      breakpoint-handle="display"
      :placeholder="responsivePlaceholder(display, 'attributes', bp)"
      v-model="display.attributes" />
    <select-field
      class="w-100"
      handle="property"
      :placeholder="responsivePlaceholder(display, 'property', bp)"
      :config="{
        label: 'Property',
        options: [
          { value: 'flex', label: 'Flex' },
          { value: 'grid', label: 'Grid' },
        ],
        taggable: true,
      }"
      v-model="display.property[bp]" />

    <div
      class="d-flex flex-column gap-3"
      v-if="display.property[bp] === 'flex'">
      <div class="d-flex gap-3">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="flex-direction"
          :placeholder="responsivePlaceholder(display, 'flex-direction', bp)"
          :config="{
            label: 'Flex Direction',
            options: [
              { value: 'flex-row', label: 'Row' },
              { value: 'flex-row-reverse', label: 'Row Reverse' },
              { value: 'flex-column', label: 'Column' },
              { value: 'flex-column-reverse', label: 'Column Reverse' },
            ],
          }"
          v-model="display['flex-direction'][bp]" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="flex-wrap"
          :placeholder="responsivePlaceholder(display, 'flex-wrap', bp)"
          :config="{
            label: 'Wrap',
            options: [
              { value: 'flex-nowrap', label: 'No Wrap' },
              { value: 'flex-wrap', label: 'Wrap' },
              { value: 'flex-wrap-reverse', label: 'Wrap Reverse' },
            ],
          }"
          v-model="display['flex-wrap'][bp]" />
      </div>
      <div class="d-flex gap-3">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="justify-content"
          :placeholder="responsivePlaceholder(display, 'justify-content', bp)"
          :config="{
            label: 'Justify Content',
            options: [
              { value: 'start', label: 'Start' },
              { value: 'end', label: 'End' },
              { value: 'center', label: 'Center' },
              { value: 'between', label: 'Between' },
              { value: 'around', label: 'Around' },
            ],
          }"
          v-model="display['justify-content'][bp]" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="align-items"
          :placeholder="responsivePlaceholder(display, 'align-items', bp)"
          :config="{
            label: 'Align Items',
            options: [
              { value: 'start', label: 'Start' },
              { value: 'end', label: 'End' },
              { value: 'center', label: 'Center' },
              { value: 'baseline', label: 'Baseline' },
              { value: 'stretch', label: 'Stretch' },
            ],
          }"
          v-model="display['align-items'][bp]" />
      </div>
      <div class="d-flex gap-3">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="align-self"
          :placeholder="responsivePlaceholder(display, 'align-self', bp)"
          :config="{
            label: 'Align Self',
            options: [
              { value: 'start', label: 'Start' },
              { value: 'end', label: 'End' },
              { value: 'center', label: 'Center' },
              { value: 'baseline', label: 'Baseline' },
              { value: 'stretch', label: 'Stretch' },
            ],
          }"
          v-model="display['align-self'][bp]" />
        <select-field
          class="flex flex-grow-1 flex-basis-0"
          handle="align-content"
          :placeholder="responsivePlaceholder(display, 'align-content', bp)"
          :config="{
            label: 'Align Content',
            options: [
              { value: 'start', label: 'Start' },
              { value: 'end', label: 'End' },
              { value: 'center', label: 'Center' },
              { value: 'around', label: 'Around' },
              { value: 'stretch', label: 'Stretch' },
            ],
          }"
          v-model="display['align-content'][bp]" />
      </div>
    </div>

    <div v-if="display.property[bp] === 'grid'">
      <div class="d-flex gap-3">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="grid-template-rows"
          :placeholder="
            responsivePlaceholder(display, 'grid-template-rows', bp)
          "
          :config="{
            label: 'Grid Template Rows',
            options,
            taggable: true,
          }"
          v-model="display['grid-template-rows'][bp]" />
        <select-field
          class="flex flex-grow-1 flex-basis-0"
          handle="row-gap"
          :placeholder="
            responsivePlaceholder(display, 'grid-template-columns', bp)
          "
          :config="{
            label: 'Grid Template Columns',
            options,
            taggable: true,
          }"
          v-model="display['grid-template-columns'][bp]" />
      </div>
    </div>

    <div class="d-flex gap-3">
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="column-gap"
        :placeholder="responsivePlaceholder(display, 'column-gap', bp)"
        :config="{
          label: 'Column Gap',
          options,
          taggable: true,
        }"
        v-model="display['column-gap'][bp]" />
      <select-field
        class="flex flex-grow-1 flex-basis-0"
        handle="row-gap"
        :placeholder="responsivePlaceholder(display, 'row-gap', bp)"
        :config="{
          label: 'Row Gap',
          options,
          taggable: true,
        }"
        v-model="display['row-gap'][bp]" />
    </div>

    <select-field
      class="flex-grow-1 flex-basis-0"
      handle="order"
      :placeholder="responsivePlaceholder(display, 'order', bp)"
      :config="{
        label: 'Order',
        options,
        taggable: true,
        popover: 'Only works if the parent has flex or grid properties.',
      }"
      v-model="display['order'][bp]" />
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
