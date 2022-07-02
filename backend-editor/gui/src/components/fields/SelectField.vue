<script setup lang="ts">
import vSelect from "vue-select"
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs, ref, watch } from "vue"
import "vue-select/dist/vue-select.css"

const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)
const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const selected = ref(modelValue?.value)

const options = normaliseOptions(config.value.options) || []

watch(selected, (value) => {
  update(value)
})
</script>
<template>
  <div class="select-field">
    <field-label
      v-if="config.label !== false"
      :label="config.label || handle" />
    <v-select
      :multiple="config?.multiple"
      :taggable="config?.taggable"
      :reduce="(option: any) => option?.value || option?.label"
      v-model="selected"
      :name="handle"
      :options="options" />
  </div>
</template>
<style lang="scss">
.select-field {
  .vs__search {
    border: 0;
  }
  .v-select:not(.vs--open) .vs__selected {
    border: 1px solid #ccc;
    padding: 0 0.6em;
  }
}
</style>
