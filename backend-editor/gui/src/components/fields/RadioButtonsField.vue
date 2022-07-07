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
    <div class="d-flex gap-1">
      <template
        v-for="(option, $index) in options"
        :key="$index"
        class="option">
        <input
          type="radio"
          :class="config?.input_class || 'btn-check'"
          :name="handle"
          :id="handle + '-' + $index"
          @input="update(($event?.target as HTMLInputElement)?.value)"
          :value="option.value"
          :disabled="isReadOnly"
          :checked="modelValue == option.value" />
        <label
          :class="config?.label_class || 'btn'"
          :for="handle + '-' + $index"
          >{{ option.label || option.value }}</label
        >
      </template>
    </div>
  </div>
</template>

<style lang="scss">
#app {
  .btn-check {
    &:checked {
      &,
      &:hover {
        + label {
          background-color: var(--bs-indigo);
          border-color: var(--bs-indigo);
        }
      }
    }

    + label {
      &,
      &:hover {
        color: white;
        background-color: var(--bs-gray-400);
        border-color: var(--bs-gray-400);
      }
    }
  }
}
</style>
