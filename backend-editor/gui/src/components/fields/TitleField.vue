<script lang="ts" setup>
import { toRefs, ref, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue, uuid } = toRefs(props)
const value = ref(modelValue?.value || {})

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)
watch(value.value, (newValue) => {
  update(newValue)
})
</script>

<template>
  <div class="card border-0 bg-100">
    <div class="card-header pb-1 border-0">
      <field-label
        class="fs-5"
        v-if="config.label !== false"
        :label="config?.label !== undefined ? config.label : handle" />
    </div>
    <field-group class="card-body">
      <richtext-field
        class="w-100"
        handle="text"
        :config="{
          ...config,
          label: false,
        }"
        v-model="value['text']" />
      <div class="d-flex gap-4">
        <radio-buttons-field
          class=""
          handle="level"
          :uuid="uuid"
          :config="{
            ...config,
            label: 'Level',
            options: ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
          }"
          v-model="value['level']" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="size"
          :config="{
            label: 'Size',
            options: ['h1', 'h2'],
            placeholder: 'Default',
            taggable: true,
          }"
          v-model="value['size']" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="colour"
          :config="{
            label: 'Colour',
            options: ['Primary', 'Secondary'],
            placeholder: 'Default',
            taggable: true,
          }"
          v-model="value['colour']" />
      </div>
      <text-field
        class=""
        handle="class"
        type="text"
        :value="value['class']"
        :config="{
          label: 'Class',
        }" />
    </field-group>
  </div>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
