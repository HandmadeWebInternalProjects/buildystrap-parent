<script setup lang="ts">
import vSelect from "vue-select"
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs, computed } from "vue"
import "vue-select/dist/vue-select.css"

const props = defineProps({
  ...commonProps,
  loading: { type: Boolean, default: false },
})

const { handle, config, modelValue } = toRefs(props)
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
  <div class="select-field">
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle" />
    <v-select
      :loading="props.loading"
      :multiple="config?.multiple"
      :taggable="config?.taggable"
      :reduce="(option: any) => option?.value || option?.label"
      v-model="selected"
      :name="handle"
      :placeholder="config.placeholder"
      :options="options" />
  </div>
</template>
<style lang="scss">
.select-field {
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
