<script lang="ts" setup>
import { useFieldType } from "./useFieldType"
import { toRefs } from "vue"
import { commonProps } from "./useFieldType"

const props = defineProps(commonProps)

const { handle, config, modelValue } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
</script>

<template>
  <div>
    <field-type-label :label="config.display || handle" />
    <toggle-button
      :value="modelValue"
      @input="update"
      :read-only="isReadOnly" />
  </div>
</template>

<style lang=""></style>
