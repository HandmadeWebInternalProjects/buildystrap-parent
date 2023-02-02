<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { onMounted, toRefs } from "vue"

const props = defineProps(commonProps)

const { handle, config, modelValue, uuid } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const options = normaliseOptions(config.value.options) || []

onMounted(() => {
  if (config?.value?.default && !modelValue?.value) {
    update(config.value.default)
  }
})
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
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
          :class="config?.label_class || 'btn btn-sm'"
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
        padding: 0 10px;
        color: white;
        line-height: 30px;
        background-color: var(--bs-gray-400);
        border-color: var(--bs-gray-400);
      }
    }
  }
}
</style>
