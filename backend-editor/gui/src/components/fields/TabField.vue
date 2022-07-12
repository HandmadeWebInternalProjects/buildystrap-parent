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
    <div class="mb-3" v-if="values.length">
      <bs-tabs v-if="values.length">
        <bs-tab
          v-for="(tab, i) in values"
          :key="tab._uuid"
          :uuid="tab._uuid"
          :active="i === 0"
          :name="tab?.title || `New Tab`">
          <field-group>
            <text-field
              handle="accordion-title"
              :config="{ label: 'Title' }"
              v-model="tab['title']" />
            <richtext-field
              handle="accordion-content"
              :config="{ ...config, label: 'Content' }"
              v-model="tab['content']"
              :uuid="tab._uuid" />
          </field-group>
        </bs-tab>
      </bs-tabs>
    </div>
    <button
      @click="addItem"
      type="button"
      class="btn btn-primary bg-indigo-500">
      Add item
    </button>
  </div>
</template>
