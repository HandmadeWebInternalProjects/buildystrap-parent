<template>
  <div>
    <field-label :label="config?.label" v-if="config?.label" />
    <ul class="grid gap-3 m-0 p-0">
      <li
        class="g-col-3 mb-0"
        v-for="(dir, key) in values"
        :key="`box-model-${key}-${bp}`">
        <select-field
          class="d-flex flex-column-reverse sub-label"
          handle="box_model_top"
          type="text"
          :placeholder="responsivePlaceholder(values, key, bp)"
          :config="{
            label: key,
            options: getBoxModelSizing(),
            taggable: true,
          }"
          v-model="dir[bp]" />
      </li>
    </ul>
  </div>
</template>
<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { useBreakpoints } from "../../../composables/useBreakpoints"
import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { getBoxModelSizing } = useBuilderOptions()
const props = defineProps({
  breakpointHandle: {
    type: String,
    required: false,
  },
  modelValue: {
    type: Object,
    required: true,
  },
  config: {
    type: Object,
    required: false,
  },
})

const { bp } = useBreakpoints(props?.breakpointHandle || "global")

const emit = defineEmits(["update:modelValue"])

const { update, filterOutEmptyValues, responsivePlaceholder } =
  useFieldType(emit)

const values = reactive({
  top: {},
  bottom: {},
  left: {},
  right: {},
  ...props.modelValue,
})

watch(values, (val: any) => {
  console.log({ val })

  update(filterOutEmptyValues(val))
})
</script>
<style lang=""></style>
