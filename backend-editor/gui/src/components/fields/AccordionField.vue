<script lang="ts" setup>
import { toRefs, computed } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { generateID } from "../../utils/id"

const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const addItem = () => {
  values.value = [...values.value, { _uuid: generateID() }]
}

const removeItem = (uuid: string) => {
  if (confirm("Are you sure you want to delete this item?")) {
    values.value = values.value.filter((el) => el._uuid !== uuid)
  }
}

const values = computed({
  get() {
    return modelValue?.value || []
  },
  set(newVal: Array<any>) {
    update(newVal)
  },
})
</script>

<template>
  <div>
    <label class="w-100">
      <field-label
        v-if="config.label !== false"
        :label="config?.label !== undefined ? config.label : handle"
        :popover="config?.popover" />
    </label>
    <draggable
      v-if="values.length"
      :list="values"
      group="accordion-items"
      item-key="_uuid"
      class="accordion mb-3"
      id="accordionExample">
      <template #item="{ element, index }">
        <bs-accordion-item
          :title="element?.title || `Item ${index + 1}`"
          :uuid="element._uuid"
          @remove="removeItem">
          <field-group>
            <text-field
              class="g-col-12"
              handle="accordion-title"
              :config="{ label: 'Title' }"
              v-model="element['title']" />
            <richtext-field
              class="g-col-12"
              handle="accordion-content"
              :config="{ ...config, label: 'Content' }"
              v-model="element['content']"
              :uuid="element._uuid" />
          </field-group>
        </bs-accordion-item>
      </template>
    </draggable>
    <button
      @click="addItem"
      type="button"
      class="btn btn-sm bg-indigo-500 text-white">
      Add item
    </button>
  </div>
</template>

<style lang="scss">
  .accordion {
    .accordion-item {
      .accordion-header {
        .accordion-button {
          span {
            font-size: 14px;
          }
        }
      }
    }
  }
</style>
