<template>
  <div>
    <field-label :label="config?.label" />
    <ul class="grid gap-4 m-0 p-0">
      <li
        class="g-col-3"
        v-for="(dir, key) in values"
        :key="`box-model-${key}-${bp}`">
        <select-field
          handle="box_model_top"
          type="text"
          :placeholder="responsivePlaceholder(values, key, bp)"
          :config="{
            label: key,
            options: options,
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
const { bp } = useBreakpoints("margin-padding")

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

// array of 10 numbers
const options = Array.from({ length: 10 }, (_, i) => i)

watch(values, (val: any) => {
  update(filterOutEmptyValues(val))
})
</script>
<style lang=""></style>
