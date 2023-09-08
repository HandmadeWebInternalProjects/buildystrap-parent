<script lang="ts" setup>
import { ref } from "vue"

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
})
const drag = ref(false)
const modules = ref(props.component?.modules)
const toggleModuleSelection = ref(false)
const colSizes = ref(props.component?.config?.columnSizes)

const handleDrop = (to: any, from: any, el: any) => {
  const validTypes = ["-module", "divider-module", "row"]
  const type = el._underlying_vm_?.type || false

  // check if validTypes contains the string 'module'
  return validTypes.filter((el) => type.includes(el)).length > 0
}
</script>

<template>
  <div
    class="border border-dashed border-300 border-2 rounded w-full d-flex flex-column p-2 justify-content-center gap-3"
    :class="[
      `g-col-12 g-col-sm-${colSizes?.sm || 'auto'} g-col-md-${
        colSizes?.md || 'auto'
      } g-col-lg-${colSizes?.lg || 'auto'} g-col-xl-${colSizes?.xl || 'auto'}`,
    ]">
    <draggable
      :list="modules"
      :group="{
        name: 'modules',
        put: handleDrop,
      }"
      item-key="uuid"
      class="section-draggable h-100 d-flex flex-grow flex-column gap-3 group"
      :component-data="{
        tag: 'div',
        type: 'transition-group',
        name: !drag ? 'flip-list' : null,
      }"
      @start="drag = true"
      @end="drag = false">
      <template #item="{ element, index }">
        <grid-row
          v-if="element.type === 'row'"
          :row-index="index"
          :parent-array="modules"
          :component="element" />
        <module-base
          v-else
          :component="element"
          :parent-array="modules"
          :component-index="index" />
      </template>
    </draggable>
    <button
      @click="toggleModuleSelection = !toggleModuleSelection"
      type="button"
      class="bg-200 text-600 border-0 py-1 rounded">
      <font-awesome-icon
        :icon="['fas', 'plus-circle']"
        width="25"
        height="25"
        fill="currentColor"
        class="cursor-pointer pulse"></font-awesome-icon>
    </button>
    <buildy-stack
      @close="toggleModuleSelection = false"
      v-if="toggleModuleSelection"
      half
      name="module-selector">
      <div class="p-4 py-5">
        <module-selector :parent-array="modules" />
      </div>
    </buildy-stack>
  </div>
</template>

<style lang="scss">
.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
</style>
