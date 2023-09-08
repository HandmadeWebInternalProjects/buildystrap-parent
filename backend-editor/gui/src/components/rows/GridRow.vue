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
  rowIndex: {
    type: Number,
    required: true,
  },
})

const columns = ref(props.component?.columns || [])
const row = ref(props.component)
const parentArray = ref(props.parentArray)
const rowIndex = computed(() => props.rowIndex)
</script>

<template>
  <div
    class="bg-100 shadow-sm border-teal-200 d-flex rounded"
    :style="`--bs-columns: ${
      row?.config?.columnCount?.md || row?.config?.columnCount || 12
    }`">
    <div
      class="sortable-handle absolute top-0 left-0 h-full bg-orange-500 rounded-start">
      <module-controls
        class="align-self-start justify-content-end text-white"
        direction="column"
        :component="row"
        :custom-settings="{
          colSelector: {
            icon: ['fas', 'columns'],
            title: 'Change Columns',
            order: 15,
            component: 'column-selector',
            isActive: false,
          },
        }"
        :value="parentArray"
        :index="rowIndex" />
    </div>
    <div class="flex-grow-1">
      <div class="grid p-2">
        <template v-for="column in columns" :key="column.uuid">
          <grid-column :component="column" />
        </template>
      </div>
    </div>
  </div>
</template>

<style lang=""></style>
