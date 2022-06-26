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
          v-if="setting.component"
          :component="component"
          :is="setting.component" />
        <font-awesome-icon
          v-else-if="setting?.icon"
          :icon="setting.icon"
          @click="setting.action"
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
import { computed, ref } from "vue"
import { recursifyID } from "../../utils/id"

import { UCFirst } from "../../utils/helpers"
import { createModule } from "../../factories/modules/moduleFactory"
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
    default: () => {},
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
const customSettings = ref(<Icon>props.customSettings)
const settingsFields = ref(<Icon>props.settingsFields)

interface Icon {
  icon?: string[]
  title?: string
  class?: string
  order?: number
  component?: any
  action?: () => void
}

const settings = computed((): Icon[] => {
  return Object.values({
    menu: {
      icon: ["fas", "pen-to-square"],
      title: "Open settings modal",
      component: "edit-module",
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
    // clipboardCopy: {
    //   // icon: this.isValidPasteLocation ? "clipboard" : "clipboard-outline",
    //   title: "Copy module to clipboard",
    //   // action: this.isValidPasteLocation
    //   //   ? this.pasteFromClipboard
    //   //   : this.copyToClipboard,
    //   order: 30,
    //   // class: this.isValidPasteLocation ? "pulse-constant" : "",
    // },
    delete: {
      icon: ["fas", "trash"],
      title: "Delete this module",
      action: removeModule,
      order: 40,
    },
    ...customSettings.value,
  })
    .filter((el: any) => el)
    .sort((a: { order: number }, b: { order: number }) => a.order - b.order)
})

const addModule = (): void => {
  const newModule = createModule(
    UCFirst(props.type || component.value.type),
    {}
  )
  parentArray.value.splice(index.value + 1, 0, newModule)
}

const cloneModule = (): void => {
  let clone = JSON.parse(JSON.stringify(component.value))
  // Generate ID's for each nested module
  recursifyID(clone)
  parentArray.value.splice(index.value + 1, 0, clone)
}

const removeModule = (): void => {
  parentArray.value.splice(index.value, 1)
}

const openModal = (): void => {
  // this.$modals.open(name);
}
</script>
