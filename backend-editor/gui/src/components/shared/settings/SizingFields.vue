<template>
  <div>
    <ul class="grid gap-3 m-0 p-0">
      <li
        class="g-col-4"
        v-for="(opt, key) in values"
        :key="`box-model-${key}-${bp}`">
        <select-field
          handle="box_model_top"
          type="text"
          :placeholder="responsivePlaceholder(values, key, bp)"
          :config="{
            label: valuesMap[key].label,
            options: options[valuesMap[key].option],
            taggable: true,
          }"
          v-model="opt[bp]" />
      </li>
    </ul>
  </div>
</template>
<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { useBreakpoints } from "../../../composables/useBreakpoints"
import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { bp } = useBreakpoints("sizing")
const { getSizing } = useBuilderOptions()

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

const { update, filterOutEmptyValues, responsivePlaceholder } =
  useFieldType(emit)

const values: any = reactive({
  minWidth: props.modelValue?.minWidth || {},
  width: props.modelValue?.width || {},
  maxWidth: props.modelValue?.maxWidth || {},
  minHeight: props.modelValue?.minHeight || {},
  height: props.modelValue?.height || {},
  maxHeight: props.modelValue?.maxHeight || {},
})

const valuesMap: any = {
  minWidth: {
    option: "width",
    label: "Min Width",
  },
  width: {
    option: "width",
    label: "Width",
  },
  maxWidth: {
    option: "width",
    label: "Max Width",
  },
  minHeight: {
    option: "height",
    label: "Min Height",
  },
  height: {
    option: "height",
    label: "Height",
  },
  maxHeight: {
    option: "height",
    label: "Max Height",
  },
}

let options: { [key: string]: string[] } = {
  width: getSizing("width"),
  height: getSizing("height"),
}

watch(values, (val: { [key: string]: string }) => {
  update(filterOutEmptyValues(val))
})
</script>
<style lang=""></style>
