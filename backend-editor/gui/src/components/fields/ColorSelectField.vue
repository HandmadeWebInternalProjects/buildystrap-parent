<script setup lang="ts">
import vSelect from "vue-select"
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs, computed } from "vue"
import { useBuilderOptions } from "@/composables/useBuilderOptions"
import "vue-select/dist/vue-select.css"

const { getThemeColours } = useBuilderOptions()

const props = defineProps({
  ...commonProps,
  reduce: {
    type: Function,
    default: (option: any) => option?.value || option?.label,
  },
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

const options = normaliseOptions(getThemeColours()) || []
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
      :reduce="reduce"
      v-model="selected"
      :name="handle"
      :disabled="config.disabled || false"
      :placeholder="placeholder || config.placeholder"
      :options="options">
      <template v-slot:option="option">
        <div class="d-flex align-items-center gap-2">
          <span :class="[`bg-${option.label}`, 'color-label-icon']"></span>
          {{ option.label }}
        </div>
      </template>
    </v-select>
  </div>
</template>

<style lang="scss">
.color-label-icon {
  width: 1.2rem;
  height: 1.2rem;
  border-radius: 50%;
}
</style>
