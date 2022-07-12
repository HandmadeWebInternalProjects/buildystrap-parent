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
  "grid-template-rows": props.modelValue["row-gap"] || {},
  "grid-template-columns": props.modelValue["row-gap"] || {},
  "column-gap": props.modelValue["column-gap"] || {},
  "row-gap": props.modelValue["row-gap"] || {},
  order: props.modelValue["row-gap"] || {},
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
        options: ['relative', 'absolute', 'fixed', 'sticky', 'static'],
        popover: 'Attributes have no effect on non-positioned elements.',
      }"
      v-model="display.position[bp]" />
    <box-model-fields
      breakpoint-handle="display"
      :placeholder="responsivePlaceholder(display, 'attributes', bp)"
      v-model="display.attributes[bp]" />
    <select-field
      class="w-100"
      handle="property"
      :placeholder="responsivePlaceholder(display, 'property', bp)"
      :config="{
        label: 'Property',
        options: ['flex', 'grid'],
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
            options: ['row', 'row-reverse', 'column', 'column-reverse'],
          }"
          v-model="display['flex-direction'][bp]" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="flex-wrap"
          :placeholder="responsivePlaceholder(display, 'flex-wrap', bp)"
          :config="{
            label: 'Wrap',
            options: ['nowrap', 'wrap', 'wrap-reverse'],
          }"
          v-model="display['align-self'][bp]" />
      </div>
      <div class="d-flex gap-3">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="justify-content"
          :placeholder="responsivePlaceholder(display, 'justify-content', bp)"
          :config="{
            label: 'Justify Content',
            options: ['start', 'end', 'center', 'between', 'around'],
          }"
          v-model="display['justify-content'][bp]" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="align-items"
          :placeholder="responsivePlaceholder(display, 'align-items', bp)"
          :config="{
            label: 'Align Items',
            options: ['start', 'end', 'center', 'baseline', 'stretch'],
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
            options: ['start', 'end', 'center', 'baseline', 'stretch'],
          }"
          v-model="display['align-self'][bp]" />
        <select-field
          class="flex flex-grow-1 flex-basis-0"
          handle="align-content"
          :placeholder="responsivePlaceholder(display, 'align-content', bp)"
          :config="{
            label: 'Align Content',
            options: ['start', 'end', 'center', 'around', 'stretch'],
          }"
          v-model="display['align-self'][bp]" />
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
        v-model="display['align-self'][bp]" />
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
      handle="align-items"
      :placeholder="responsivePlaceholder(display, 'align-items', bp)"
      :config="{
        label: 'Order',
        options,
        taggable: true,
        popover: 'Only works if the parent has flex or grid properties.',
      }"
      v-model="display['align-items'][bp]" />
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
