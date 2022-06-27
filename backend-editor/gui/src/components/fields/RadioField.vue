<script lang="ts" setup>
import { useFieldType } from "./useFieldType"
import { toRefs } from "vue"
import { commonProps } from "./useFieldType"

const props = defineProps(commonProps)

const { handle, config, modelValue } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const options = normaliseOptions(config.value.options) || []
</script>

<template>
  <div>
    <field-label :label="config.display || handle" />
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
