<script setup lang="ts">
import vSelect from "vue-select"
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs, computed } from "vue"
import "vue-select/dist/vue-select.css"

const props = defineProps({
  ...commonProps,
  loading: { type: Boolean, default: false },
})

const { handle, config, modelValue, placeholder } = toRefs(props)
const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const selected = computed({
  get() {
    return modelValue?.value
  },
  set(newVal) {
    update(newVal)
  },
})
const options = normaliseOptions(config.value.options) || []
</script>
<template>
  <div class="select-field position-relative">
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover"
      :responsive="config?.responsive" />
    <v-select
      :loading="props.loading"
      :multiple="config?.multiple"
      :taggable="config?.taggable"
      :reduce="(option: any) => option?.value || option?.label"
      v-model="selected"
      :name="handle"
      :disabled="config.disabled || false"
      :placeholder="placeholder || config.placeholder"
      :options="Object.keys(options).length ? options : null">
    </v-select>
  </div>
</template>
<style lang="scss">
.select-field {
  text-transform: capitalize;

  &.sub-label {
    label {
      font-size: 0.7em;
    }
  }
  .vs__dropdown-toggle {
    background: white;
  }
  .vs__search {
    border: 0;
  }
  .v-select:not(.vs--open) .vs__selected {
    background: var(--bs-gray-100);
    border: 1px solid #ccc;
    padding: 0 0.6em;
  }
}
</style>
