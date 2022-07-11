<template>
  <div>
    <field-label :label="config?.label" />
    <ul class="grid gap-4 m-0 p-0">
      <li
        class="g-col-6"
        v-for="(opt, key) in values"
        :key="`box-model-${key}-${bp}`">
        <select-field
          handle="box_model_top"
          type="text"
          :placeholder="responsivePlaceholder(values, key, bp)"
          :config="{
            label: key,
            options: options[key],
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
const { bp } = useBreakpoints("sizing")

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
  width: props.modelValue?.width || {},
  height: props.modelValue?.height || {},
})

// Options will eventually come from site options
const options: { [key: string]: string[] } = {
  width: [
    "100%",
    "100vw",
    "1 / 2 (50%)",
    "1 / 3 (33.33%)",
    "2 / 3 (66.66%)",
    "1 / 4 (25%)",
    "2 / 4 (50%)",
    "3 / 4 (75%)",
    "1 / 5 (20%)",
    "2 / 5 (40%)",
    "3 / 5 (60%)",
    "4 / 5 (80%)",
    "1 / 6 (16.66%)",
    "2 / 6 (33.33%)",
    "3 / 6 (50%)",
    "4 / 6 (66.66%)",
    "5 / 6 (83.33%)",
  ],
  height: [
    "100%",
    "100vh",
    "1 / 2 (50%)",
    "1 / 3 (33.33%)",
    "2 / 3 (66.66%)",
    "1 / 4 (25%)",
    "2 / 4 (50%)",
    "3 / 4 (75%)",
    "1 / 5 (20%)",
    "2 / 5 (40%)",
    "3 / 5 (60%)",
    "4 / 5 (80%)",
    "1 / 6 (16.66%)",
    "2 / 6 (33.33%)",
    "3 / 6 (50%)",
    "4 / 6 (66.66%)",
    "5 / 6 (83.33%)",
  ],
}

watch(values, (val: { [key: string]: string }) => {
  update(filterOutEmptyValues(val))
})
</script>
<style lang=""></style>
