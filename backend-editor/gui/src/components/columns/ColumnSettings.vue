<template lang="">
  <button
    type="button"
    class="btn btn-sm"
    :class="
      [`btn g-col-sm-${columnSizes?.sm || 'auto'} g-col-md-${columnSizes?.md || 'auto'} g-col-lg-${columnSizes?.lg || 'auto'} g-col-xl-${columnSizes?.xl || 'auto'}`,
      isOpen ? 'bg-orange-500 text-white' : 'border-orange-500 text-orange-500']
    "
    @click="toggleItem(uuid)">
    Edit Column {{ index + 1 }}
  </button>
  <bs-tabs v-if="isOpen" class="column-options g-col-12 bg-200 rounded p-4">
    <bs-tab :uuid="`modules-${uuid}`" :active="true" name="modules">
      <div class="d-flex flex-column gap-4">
        <bs-card
        label="Module Gap"
        popover="Select the spacing size between the module/s">
          <template v-slot:body>
            <select-field
              handle="modules"
              :config="{ label: false, options: ['1', '2', '3', '4', '5'] }"
              v-model="moduleGap" />
          </template>
        </bs-card>
        <bs-card
        label="Column Sizes"
        popover="Select the breakpoint sizes for the column">
          <template v-slot:body>
            <ul class="m-0 p-0 grid gap-2">
              <li
                class="g-col-6"
                v-for="breakpoint in breakpoints"
                :key="`${uuid}-${breakpoint}`">
                <div class="position-relative d-flex flex-column sub-label">
                  <input
                    type="text"
                    :id="`${uuid}-${breakpoint}`"
                    v-model="columnSizes[breakpoint]" />
                  <label :for="`${uuid}-${breakpoint}`" class="breakpoint-label text-600">{{ breakpoint }}</label>
                </div>
              </li>
            </ul>
          </template>
        </bs-card>
      </div>
    </bs-tab>
    <bs-tab :uuid="`design-${uuid}`" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab :uuid="`attributes-${uuid}`" name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
    <bs-tab :uuid="`visibility-${uuid}`" name="visibility">
      <visibility-tab-settings v-model="config" />
    </bs-tab>
  </bs-tabs>
</template>

<script setup lang="ts">
import { generateID } from "@/utils/id"
import { ref, computed, provide } from "vue"

import { useToggleByID } from "@/composables/useToggleByID"
import { breakpoints } from "@/composables/useBreakpoints"

const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
  index: Number,
  component: {
    type: Object,
    required: true,
  },
})

const component = ref(props.component)

// Module styles injection
provide("component", component.value)

const uuid = generateID()

const { isOpen, toggleItem } = useToggleByID(uuid)

const field = ref(props.field)

const columnSizes = ref(field.value.config.columnSizes)

const inline = computed({
  get() {
    return field.value?.inline || {}
  },
  set(value) {
    field.value.inline = value
  },
})

const moduleGap = computed({
  get() {
    return field.value?.inline?.moduleGap || undefined
  },
  set(value) {
    inline.value = { ...inline.value, moduleGap: value }
  },
})

const attributes = computed({
  get() {
    return field.value?.attributes || {}
  },
  set(value) {
    field.value.attributes = value
  },
})

const config = computed({
  get() {
    return field.value?.config || {}
  },
  set(value) {
    field.value.config = value
  },
})
</script>

<style lang="scss">
.column-options {
  order: 99;
}
.breakpoint-label {
  text-transform: none !important;
}
</style>
