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
  "combine-gaps": props.modelValue["combine-gaps"] || false,
  gap: props.modelValue["gap"] || {},
  "column-gap": props.modelValue["column-gap"] || {},
  "row-gap": props.modelValue["row-gap"] || {},
  order: props.modelValue["order"] || {},
})

const options = Array.from({ length: 21 }, (_, i) => i)

watch(display, (val: any) => {
  /* 
    This will remove all properties that are not flex or grid
    at each respective breakpoint. So if you have it set to flex
    or grid and add those properties, then change it to a non-flex 
    or grid property, it will remove those properties.
  */
  if (val.property) {
    Object.keys(val.property).forEach((key) => {
      if (
        val.property[key] !== "flex" &&
        val.property[key] !== "grid" &&
        val.property[key] !== "inline-flex" &&
        val.property[key] !== "inline-grid"
      ) {
        delete val["flex-direction"][key]
        delete val["flex-wrap"][key]
        delete val["justify-content"][key]
        delete val["align-items"][key]
        delete val["align-self"][key]
        delete val["align-content"][key]
        delete val["grid-template-rows"][key]
        delete val["grid-template-columns"][key]
        delete val["combine-gaps"][key]
        delete val["gap"][key]
        delete val["column-gap"][key]
        delete val["row-gap"][key]
      }
    })
  }
  update(filterOutEmptyValues(val))
})
</script>

<template>
  <field-group>
    <select-field
      class="g-col-12 w-100"
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
      class="g-col-12"
      breakpoint-handle="display"
      :placeholder="responsivePlaceholder(display, 'attributes', bp)"
      v-model="display.attributes" />
    <select-field
      class="g-col-12 w-100"
      handle="property"
      :placeholder="responsivePlaceholder(display, 'property', bp)"
      :config="{
        label: 'Property',
        options: [
          { value: 'none', label: 'None (hidden)' },
          { value: 'block', label: 'Block' },
          { value: 'inline', label: 'Inline' },
          { value: 'inline-block', label: 'Inline Block' },
          { value: 'inline-flex', label: 'Inline Flex' },
          { value: 'flex', label: 'Flex' },
          { value: 'grid', label: 'Grid' },
        ],
      }"
      v-model="display.property[bp]" />

    <div
      class="g-col-12 d-flex flex-column gap-3">
      <div
        v-if="
          display.property[bp] === 'flex' ||
          responsivePlaceholder(display, 'property', bp) == 'flex'
        "
        class="d-flex gap-3">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="flex-direction"
          :placeholder="responsivePlaceholder(display, 'flex-direction', bp)"
          :config="{
            label: 'Flex Direction',
            options: [
              { value: 'row', label: 'Row' },
              { value: 'row-reverse', label: 'Row Reverse' },
              { value: 'column', label: 'Column' },
              { value: 'column-reverse', label: 'Column Reverse' },
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
              { value: 'nowrap', label: 'No Wrap' },
              { value: 'wrap', label: 'Wrap' },
              { value: 'wrap-reverse', label: 'Wrap Reverse' },
            ],
          }"
          v-model="display['flex-wrap'][bp]" />
      </div>
      <div
        v-if="
          display.property[bp] === 'flex' ||
          responsivePlaceholder(display, 'property', bp) == 'flex' ||
          display.property[bp] === 'grid' ||
          responsivePlaceholder(display, 'property', bp) == 'grid'
        "
       class="g-col-12 d-flex gap-3">
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
      <div class="g-col-12 d-flex gap-3">
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

    <div v-if="display.property[bp] === 'grid' || responsivePlaceholder(display, 'property', bp) == 'grid'" class="g-col-12">
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
          }"
          v-model="display['grid-template-columns'][bp]" />
      </div>
    </div>

    <div class="g-col-12">
      <toggle-field
        handle="combine-gaps"
        :config="{
          label: 'Combine Gaps',
          description: 'Combine the row and column gaps into one value',
        }"
        v-model="display['combine-gaps']" />
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="gap"
        v-if="display['combine-gaps']"
        :placeholder="responsivePlaceholder(display, 'gap', bp)"
        :config="{
          label: 'Gap',
          options,
          taggable: true,
        }"
        v-model="display['gap'][bp]" />
      <div class="d-flex gap-3" v-else>
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
    </div>

    <select-field
      class="g-col-12 flex-grow-1 flex-basis-0"
      handle="order"
      :placeholder="responsivePlaceholder(display, 'order', bp)"
      :config="{
        label: 'Order',
        options: [-1, ...options, 99, 999, 9999],
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
