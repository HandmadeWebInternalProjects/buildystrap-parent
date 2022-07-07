<script lang="ts" setup>
import { useFieldType, commonProps } from "./useFieldType"
import { ref, toRefs, watch } from "vue"

const props = defineProps(commonProps)

const { handle, config, modelValue } = toRefs(props)

const isReadOnly = config.value.readOnly || false

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const options = normaliseOptions(config.value.options) || []
const values = ref<any>(modelValue?.value || [])

watch(values, (newValue) => {
  update(newValue)
})
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle" />
    <div
      class="checkboxes-fieldtype-wrapper"
      :class="{ 'inline-mode': config?.inline }">
      <div class="option" v-for="(option, $index) in options" :key="$index">
        <label>
          <input
            type="checkbox"
            :name="handle + '[]'"
            :value="option.value"
            :disabled="isReadOnly"
            v-model="values" />
          {{ option.label || option.value }}
        </label>
      </div>
    </div>
  </div>
</template>

<style lang=""></style>
