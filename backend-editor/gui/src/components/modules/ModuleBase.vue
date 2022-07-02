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
  customSettings: {
    type: Object,
    default: () => ({}),
  },
})

const component = ref(props.component)
provide("component", component)

const columns = ref(props.columns)
const componentIndex = computed((): number => props.componentIndex)

const isGlobalModule = computed((): boolean => {
  return component.value.type.includes("global")
})
</script>
<template>
  <div
    class="shadow-sm text-white rounded d-flex"
    :class="[isGlobalModule ? 'bg-teal-700' : 'bg-700']">
    <div
      class="sortable-handle handle-single align-items-center absolute top-0 left-0 h-full rounded-start"
      :class="[isGlobalModule ? 'bg-teal-800' : 'bg-800']"></div>
    <div
      class="d-flex flex-row justify-content-between align-items-center flex-grow-1 px-3 py-2">
      <span
        class="module-title flex-grow-1 py-1 me-2 text-nowrap overflow-hidden"
        >{{ component?.config?.adminLabel || component.type }}</span
      >
      <module-controls
        class="justify-content-center text-white"
        direction="row"
        :component="component"
        :value="columns"
        :index="componentIndex"
        :custom-settings="{ add: false, ...customSettings }" />
    </div>
  </div>
</template>
<style lang="scss">
.module-title {
  width: 1px;
  font-size: 14px;
}
</style>
