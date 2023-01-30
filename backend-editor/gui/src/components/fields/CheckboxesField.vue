<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { generateID } from "@/utils/id"
import { ref, watch, toRefs, onMounted } from "vue"
import * as bootstrap from "bootstrap"

const props = defineProps({
  ...commonProps,
  popover: {
    type: String,
  },
})

const uuid = generateID()

const { handle, config, modelValue } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const options: any = normaliseOptions(config.value.options) || []

const selected = ref<string[]>(modelValue?.value ?? [])

watch(selected, (value) => {
  update(value)
})

onMounted(() => {
  const popoverTriggerList: any = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
  )
  const popoverList: any = [...popoverTriggerList].map(
    (popoverTriggerEl) =>
      new bootstrap.Popover(popoverTriggerEl, {
        placement: "right",
        trigger: "focus",
      })
  )
})
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <div
      class="checkboxes-fieldtype-wrapper d-flex gap-1"
      :class="{ 'inline-mode': config?.inline }">
      <div
        class="option"
        v-for="option in options"
        :key="`${uuid}-${option.value}`">
        <input
          type="checkbox"
          class="btn-check"
          :id="`${handle}_${uuid}_[${option.value}]`"
          :value="option.value"
          :disabled="isReadOnly"
          v-model="selected" />
        <label
          class="checkbox-label btn btn-sm bg-indigo-500 text-white"
          :for="`${handle}_${uuid}_[${option.value}]`">
          {{ option.label || option.value }}
        </label>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.checkbox-label {
  text-transform: none !important;
}
</style>
