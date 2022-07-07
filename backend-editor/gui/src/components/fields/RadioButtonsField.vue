<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs } from "vue"

const props = defineProps(commonProps)

const { handle, config, modelValue, uuid } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const options = normaliseOptions(config.value.options) || []
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle" />
    <div class="d-flex gap-1">
      <template
        v-for="option in options"
        :key="`${option.value}-${handle}-${uuid}`">
        <input
          type="radio"
          :class="config?.input_class || 'btn-check'"
          :name="handle"
          :id="`${option.value}-${handle}-${uuid}`"
          @input="update(($event?.target as HTMLInputElement)?.value)"
          :value="option.value"
          :disabled="isReadOnly"
          :checked="modelValue == option.value" />
        <label
          :class="config?.label_class || 'btn'"
          :for="`${option.value}-${handle}-${uuid}`"
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
