<template>
  <bs-card-collapse :active="config?.active ?? false" :label="config.label">
    <template v-slot:body>
      <field-group :gap="config?.gap" v-if="fields">
        <field-base
          v-for="(field, key) in fields"
          :field="field"
          :key="key"
          :handle="key"
          :type="field.type"
          :module-type="moduleType"
          :config="field.config || {}"
          v-model="values" />
      </field-group>
    </template>
  </bs-card-collapse>
</template>

<script setup lang="ts">
import { toRefs, onMounted, reactive, watch, computed } from "vue"
import { useFieldType, commonProps } from "../useFieldType"
import { findNestedObject } from "../../../utils/objects"
import { useBuilderStore } from "../../../stores/builder"

const props = defineProps({
  ...commonProps,
})

let values = reactive(props.modelValue ? props.modelValue : {})

const { getModuleBlueprintForType } = useBuilderStore()

const { handle, moduleType } = toRefs(props)

const emit = defineEmits(["update:modelValue"])
const { update } = useFieldType(emit)

const fields = reactive<any>({})

const set: any = computed(() => {
  return getModuleBlueprintForType(moduleType.value)
})

onMounted(() => {
  const { fields: foundFields } = findNestedObject(set.value, handle?.value)
  Object.assign(fields, foundFields || {})
  // Make sure the values object has all the keys from the fields object
  // Object.keys(fields).forEach((key) => {
  //   if (!values[key]) {
  //     values[key] = {}
  //   }
  // })
})

watch(
  values,
  (newValue) => {
    update(newValue)
  },
  { deep: true }
)
</script>
