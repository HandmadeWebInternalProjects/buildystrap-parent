<template>
  <div
    class="module-controls d-flex text-center"
    :data-testid="`${type || component.type}-controls`">
    <ul
      :class="`list-unstyled d-flex flex-${direction} m-0 p-0 gap-2 overflow-x-auto pb-0`">
      <li
        class="flex-shrink-0 m-0"
        v-for="(setting, i) in settings"
        :key="component.uuid + type + i"
        :title="setting.title">
        <component
          v-if="setting.component && setting?.isActive"
          :component="component"
          @close="handleClose(setting)"
          :is="setting.component" />
        <font-awesome-icon
          :icon="setting.icon"
          @click="handleClick(setting, i)"
          width="15"
          height="15"
          fill="currentColor"
          class="flex cursor-pointer pulse"
          :class="[setting.class || '']"></font-awesome-icon>
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { computed, ref, reactive } from "vue"
import { recursifyID } from "../../utils/id"

import { UCFirst } from "../../utils/helpers"
import { createModule } from "../../factories/modules/moduleFactory"
import { useClipboard } from "@/composables/useClipboard"

// import { EvaIcon } from "vue-eva-icons";
// import ModuleSelector from "../ModuleSelector.vue";
// import SettingStack from "../shared/SettingStack.vue";
// import ClipboardFunctions from "../../mixins/ClipboardFunctions";

const props = defineProps({
  value: {
    type: Array,
    required: true,
  },
  index: {
    type: Number,
    default: 0,
  },
  customSettings: {
    type: Object,
    default: () => ({}),
  },
  direction: {
    type: String,
  },
  component: {
    type: Object,
    required: true,
  },
  settingsFields: {
    type: Array,
    default: () => [],
  },
  type: String,
})

const index = computed(() => props.index)
const parentArray = ref(props.value || [])
const component = ref(props.component)
const customSettings = ref(props.customSettings)
const settingsFields = ref(props.settingsFields)

const { isValidPasteLocation, pasteFromClipboard, copyToClipboard } =
  useClipboard(component.value)

type ControlItem = {
  icon?: string[]
  isActive?: boolean
  title?: string
  class?: string
  order?: number
  component?: any
  action?: any
}

const settings = computed((): ControlItem[] => {
  return reactive(
    Object.values({
      menu: {
        icon: ["fas", "pen-to-square"],
        title: "Open settings modal",
        component: "edit-module",
        isActive: false,
        order: 10,
      },
      add: {
        icon: ["fas", "plus-circle"],
        title: "Add module right after this module",
        action: addModule,
        order: 20,
      },
      clone: {
        icon: ["fas", "copy"],
        title: "Clone this module",
        action: cloneModule,
        // condition: this.component,
        order: 30,
      },
      clipboardCopy: navigator?.clipboard
        ? {
            icon: isValidPasteLocation.value
              ? ["fas", "clipboard-check"]
              : ["fas", "clipboard"],
            title: isValidPasteLocation.value
              ? "Paste module here (after this one)"
              : "Copy module to clipboard",
            action: isValidPasteLocation.value
              ? () => pasteFromClipboard(pasteModule)
              : copyToClipboard,
            order: 30,
            class: isValidPasteLocation.value
              ? "text-green-300 animate-pulse"
              : "",
          }
        : {},
      delete: {
        icon: ["fas", "trash"],
        title: "Delete this module",
        action: removeModule,
        order: 40,
      },
      ...customSettings.value,
    })
  )
    .filter((el: any) => Object.hasOwnProperty.call(el, "order"))
    .sort((a: any, b: any) => a.order - b.order)
})

const handleClick = (setting: any, i: number): void => {
  if (Object.hasOwnProperty.call(setting, "isActive")) {
    setting.isActive = !setting.isActive
  }
  if (setting?.action) {
    setting.action()
  }
}

const handleClose = (setting: any): void => {
  setting.isActive = false
}

const addModule = (): void => {
  const newModule = createModule(
    UCFirst(props.type || component.value.type),
    {}
  )
  parentArray.value.splice(index.value + 1, 0, newModule)
}

const cloneModule = (): void => {
  const clone = JSON.parse(JSON.stringify(component.value))
  // Generate ID's for each nested module
  recursifyID(clone)
  parentArray.value.splice(index.value + 1, 0, clone)
}

const pasteModule = (fromClipBoard?: any): void => {
  recursifyID(fromClipBoard)
  parentArray.value.splice(index.value + 1, 0, fromClipBoard)
}

const removeModule = (): void => {
  parentArray.value.splice(index.value, 1)
}
</script>

<style>
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
