<script lang="ts" setup>
import { ref, computed, provide } from "vue"

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  columns: {
    type: Array,
    required: true,
  },
  componentIndex: {
    type: Number,
    required: true,
  },
})

const component = ref(props.component)
provide("component", component)

const columns = ref(props.columns)
const componentIndex = computed((): number => props.componentIndex)
</script>
<template>
  <div class="bg-700 shadow-sm text-white rounded d-flex">
    <div
      class="sortable-handle handle-single align-items-center absolute top-0 left-0 h-full rounded-start bg-800"></div>
    <div
      class="d-flex flex-row justify-content-between align-items-center flex-grow-1 px-3 py-2">
      <span
        class="module-title flex-grow-1 py-1 me-2 text-nowrap overflow-scroll"
        >{{ component.type }}</span
      >
      <module-controls
        class="justify-content-center text-white"
        direction="row"
        :component="component"
        :value="columns"
        :index="componentIndex"
        :custom-settings="{ add: false }" />
    </div>
  </div>
</template>
<style lang="scss">
.module-title {
  width: 1px;
  font-size: 14px;
}
</style>
