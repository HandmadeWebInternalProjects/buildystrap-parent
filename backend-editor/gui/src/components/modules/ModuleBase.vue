<script lang="ts" setup>
import { ref, computed, provide } from "vue"
import { slugToStr } from "../../utils/helpers"
import { useBuilderStore } from "../../stores/builder"

const { getModuleBlueprintForType } = useBuilderStore()

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  parentArray: {
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

const parentArray = ref(props.parentArray)
const componentIndex = computed((): number => props.componentIndex)

const updateAdminLabel = (val: string) => {
  component.value.config.adminLabel = val
}

// To get the icon
const blueprint = getModuleBlueprintForType(component.value.type)

const isGlobalModule = computed((): boolean => {
  return component.value.type.includes("global")
})

const customSettings = isGlobalModule.value
  ? {
      ...props.customSettings,
      clone: false,
      clipboardCopy: false,
      goToGlobal: {
        icon: ["fas", "arrow-up-right-from-square"],
        title: "Jump to this global module in a new tab",
        action: () =>
          // check if window has .open method
          window.open
            ? window.open(
                `/wp-admin/post.php?post=${props.component?.global_id}&action=edit&classic-editor`,
                "_blank"
              )
            : (window.location.href = `/wp-admin/post.php?post=${props.component?.global_id}&action=edit&classic-editor`),

        order: 10,
      },
    }
  : { ...props.customSettings }
</script>
<template>
  <div
    class="shadow-sm text-white rounded d-flex"
    :class="[isGlobalModule ? 'bg-purple-600' : 'bg-700']">
    <div
      class="sortable-handle handle-single align-items-center absolute top-0 left-0 h-full rounded-start"
      :class="[isGlobalModule ? 'bg-purple-700' : 'bg-800']"></div>
    <div
      class="d-flex group container-box position-relative flex-row justify-content-between align-items-center flex-grow-1 px-2 py-2">
      <div class="d-flex gap-1 align-items-center">
        <i :class="[blueprint?.icon]"></i>
        <span
          contenteditable="true"
          @blur="updateAdminLabel($el.innerText)"
          class="module-title flex-grow-1 w-100 p-1 me-2 text-nowrap overflow-hidden rounded-1">
          {{ component?.config?.adminLabel || slugToStr(component.type) }}
        </span>
      </div>
      <module-controls
        class="justify-content-center text-white position-absolute end-0 me-2 opacity-0 opacity-md-1 opacity-100-hover transition-opacity"
        :class="[isGlobalModule ? 'bg-purple-600' : 'bg-700']"
        direction="row"
        :component="component"
        :value="parentArray"
        :index="componentIndex"
        :custom-settings="{ add: false, ...customSettings }" />
    </div>
  </div>
</template>
<style lang="scss">
.module-title {
  width: 1px;
  font-size: 14px;

  &:focus-visible {
    outline: 1px dashed rgba(255, 255, 255, 0.5);
  }
}
</style>
