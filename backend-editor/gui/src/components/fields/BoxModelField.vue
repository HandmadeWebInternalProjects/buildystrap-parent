<template>
  <ul>
    <li @click="breakpoint = 'xs'">xs</li>
    <li @click="breakpoint = 'sm'">sm</li>
    <li @click="breakpoint = 'md'">md</li>
    <li @click="breakpoint = 'lg'">lg</li>
    <li @click="breakpoint = 'xl'">xl</li>
  </ul>
  <ul>
    <li>top: <input type="text" v-model="values.top[breakpoint]" /></li>
    <li>right <input type="text" v-model="values.right[breakpoint]" /></li>
    <li>bottom <input type="text" v-model="values.bottom[breakpoint]" /></li>
    <li>left <input type="text" v-model="values.left[breakpoint]" /></li>
  </ul>
</template>
<script lang="ts" setup>
import { reactive, ref, watch } from "vue"
import { useFieldType } from "../fields/useFieldType"
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
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

        acc[key] = val[key]
      }

      return acc
    },
    {}
  )
  console.log({ filtered })
  update(filtered)
})

const breakpoint = ref("xs")
</script>
<style lang=""></style>
