<script lang="ts" setup>
import { toRefs } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <input
      class="w-100"
      :handle="handle"
      :type="config.input_type || 'text'"
      :value="modelValue"
      @input="update(($event?.target as HTMLInputElement)?.value)"
      :placeholder="config.placeholder" />
  </div>
</template>

<style lang=""></style>
