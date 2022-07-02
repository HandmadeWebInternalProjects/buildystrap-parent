<template>
  <div>
    <field-label :label="label" />
    <ul class="d-flex gap-4 m-0 p-0">
      <li
        class="flex-grow-1"
        v-for="(dir, key) in values"
        :key="`box-model-${key}-${breakpoint}`">
        <select-field
          handle="box_model_top"
          type="text"
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
const { breakpoint } = useBreakpoints()

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  label: {
    type: String,
    required: false,
  },
})

const emit = defineEmits(["update:modelValue"])

const { update } = useFieldType(emit)

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
  //filter out any empty values
  const filtered = Object.keys(val).reduce(
    (acc: { [key: string]: any }, key: string) => {
      // remove empty values from object
      if (Object.keys(val[key]).length) {
        Object.entries(val[key]).forEach(([size, value]) => {
          if (value === "") {
            delete val[key][size]
          }
        })

        console.log(val[key])

        acc[key] = val[key]
      }

      return acc
    },
    {}
  )
  console.log({ filtered })
  update(filtered)
})
</script>
<style lang=""></style>
