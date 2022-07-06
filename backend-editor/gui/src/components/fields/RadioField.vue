<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs } from "vue"

const props = defineProps(commonProps)

const { handle, config, modelValue } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const options = normaliseOptions(config.value.options) || []
</script>

<template>
  <div>
    <field-label :label="config?.label !== undefined ? config.label : handle" />
    <div v-for="(option, $index) in options" :key="$index" class="option">
      <label>
        <input
          type="radio"
          :name="handle"
          @input="update(($event?.target as HTMLInputElement)?.value)"
          :value="option.value"
          :disabled="isReadOnly"
          :checked="modelValue == option.value" />
        {{ option.label || option.value }}
      </label>
    </div>
  </div>
</template>

<style lang=""></style>
