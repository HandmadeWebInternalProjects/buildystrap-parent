<script lang="ts" setup>
import { toRefs } from "vue"
import { useFieldType } from "./useFieldType"
import { commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
</script>

<template>
  <div>
    <label class="w-100">
      <field-label :label="config.display || handle" />
      <input
        class="w-100"
        :handle="handle"
        :type="config.input_type || 'text'"
        :value="modelValue"
        @input="update(($event?.target as HTMLInputElement)?.value)"
        placeholder="text fieldtype" />
    </label>
  </div>
</template>

<style lang=""></style>
