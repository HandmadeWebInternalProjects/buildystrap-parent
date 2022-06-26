<script lang="ts" setup>
import { useFieldType } from "./useFieldType"
import { toRefs } from "vue"

const props = defineProps({
  type: {
    type: String,
    default: "",
  },
  uuid: {
    type: String,
    default: "",
  },
  handle: {
    type: String,
    default: "",
  },
  modelValue: {
    type: [String, Object, Array],
    default: "",
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  meta: {
    type: Object,
    default: () => ({}),
  },
})

const { handle, config, modelValue } = toRefs(props)

const textConfigDefaults = {
  input_type: "text",
}

const configWithDefaults = { ...textConfigDefaults, ...config.value }

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
</script>

<template>
  <div>
    <label class="w-100">
      <span class="d-block pb-1 text-600">{{ config.display || handle }}</span>
      <input
        class="w-100"
        :handle="handle"
        :type="configWithDefaults.input_type"
        :value="modelValue"
        @input="update(($event?.target as HTMLInputElement)?.value)"
        placeholder="text fieldtype" />
    </label>
  </div>
</template>

<style lang=""></style>
