<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { generateID } from "@/utils/id"
import { computed, toRefs, onMounted } from "vue"
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

const options : any = normaliseOptions(config.value.options) || []

const values = computed<any>({
  get() {
    return modelValue?.value || []
  },
  set(val) {
    update(val)
  },
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
      <div class="option" v-for="(option, $index) in options" :key="$index">
        <input
          type="checkbox"
          class="btn-check"
          :id="`${handle}_${uuid}_[${option.value}]`"
          :name="`${handle}[${option.value}]`"
          :value="option.value"
          :disabled="isReadOnly"
          v-model="values" />
        <label class="checkbox-label btn btn-sm btn-primary" :for="`${handle}_${uuid}_[${option.value}]`">
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
