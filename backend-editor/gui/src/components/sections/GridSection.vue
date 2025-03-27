<script lang="ts" setup>
import { ref, computed } from "vue"

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  parentArray: {
    type: Array,
    required: true,
  },
  sectionIndex: {
    type: Number,
    required: true,
  },
  customSettings: {
    type: Object,
    default: () => ({}),
  },
})

const section = ref(props.component || {})
const parentArray = ref(props.parentArray || [])
const customSettings = ref(props.customSettings)
const sectionIndex = computed(() => props.sectionIndex || 0)
const rows = ref(props.component?.rows || [])
const visibility = section?.value?.config?.visibility
var visibility_classes = '';
var visibility_label = '';
if(visibility){
  visibility_label = 'Hidden on '
  visibility.forEach((item: any) => {
    visibility_classes += ' hidden-' + item
    visibility_label += item + ' '
  })
}

import { createModule } from "../../factories/modules/moduleFactory"

const addRow = () => {
  const row = createModule("Row")
  rows.value.push(row)
}

const handleDrop = (to: any, from: any, el: any) => {
  const validTypes = ["row", "divider-module"]
  const type = el._underlying_vm_?.type || false

  return type && validTypes.includes(type)
}
</script>

<template>
  <div class="buildy-section d-flex bg-200 rounded" :class="visibility_classes" :data-visibility-label="visibility_label">
    <div
      class="sortable-handle absolute top-0 left-0 h-full bg-indigo-500 rounded-start">
      <module-controls
        class="align-self-start justify-content-end text-white"
        direction="column"
        :component="section"
        :value="parentArray"
        :index="sectionIndex"
        :custom-settings="customSettings" />
    </div>
    <div class="flex-grow-1">
      <draggable
        v-if="rows.length"
        :list="rows"
        :group="{
          name: 'rows',
          put: handleDrop,
        }"
        handle=".sortable-handle"
        item-key="uuid"
        class="section-draggable d-flex flex-grow-1 p-2 flex-grow flex-column gap-3 group">
        <template #item="{ element, index }">
          <grid-row
            v-if="element.type === 'row'"
            :row-index="index"
            :parent-array="rows"
            :component="element" />
          <module-base
            v-else
            :component="element"
            :parent-array="rows"
            :component-index="index" />
        </template>
      </draggable>
      <button @click="addRow" type="button" v-else>Add row</button>
    </div>
  </div>
</template>

<style lang=""></style>
