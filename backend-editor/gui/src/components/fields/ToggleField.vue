<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs } from "vue"

const props = defineProps(commonProps)

const { handle, config, modelValue } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <toggle-button
      :value="modelValue"
      @input="update"
      :read-only="isReadOnly" />
  </div>
</template>

<style lang=""></style>
