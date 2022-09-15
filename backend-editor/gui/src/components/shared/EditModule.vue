<script lang="ts" setup>
import { ref, computed } from "vue"

import { useBuilderStore } from "../../stores/builder"
import { slugToStr } from "../../utils/helpers"
import type { EventInterface } from "../Events"
const { getRegisteredComponents } = useBuilderStore()

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  settingsFields: {
    type: Array,
    default: () => [],
  },
})

const component = ref(props.component)
const adminLabelEl = ref<HTMLElement | null>(null)

// Check if a vue component exists that provides custom settings, else use module settings (default)
const componentToLoad = computed((): string => {
  return getRegisteredComponents[component.value.type] ||
    component.value.type === "row" ||
    component.value.type === "section" ||
    component.value.type === "global-section" ||
    component.value.type === "global-module"
    ? component.value.type
    : "module"
})

const updateAdminLabel = ($el: HTMLElement) => {
  if ($el?.innerText !== null || $el?.innerText !== undefined) {
    component.value.config.adminLabel = $el?.innerText
  }
}

const focusOnAdminLabel = () => {
  if (adminLabelEl.value) {
    adminLabelEl?.value?.focus()
    document
      ?.getSelection()
      ?.collapse(
        adminLabelEl.value,
        adminLabelEl.value.childNodes.length ? 1 : 0
      )
  }
}

const settingsToggle = ref(false)
const designToggle = ref(false)
</script>
<template>
  <font-awesome-icon
    :icon="['fas', 'pen-to-square']"
    @click="settingsToggle = true"
    width="15"
    height="15"
    fill="currentColor"
    aria-controls="offcanvasRight"
    class="flex cursor-pointer pulse"></font-awesome-icon>
  <buildy-stack
    @close=";(settingsToggle = false), (designToggle = false)"
    v-if="settingsToggle"
    half
    name="module-settings">
    <div class="tab-header bg-indigo-500 text-white px-4 py-3">
      <h3 class="mb-0 d-flex gap-2">
        Edit
        <span
          class="block px-1"
          ref="adminLabelEl"
          contenteditable="true"
          @blur="updateAdminLabel($event.target as HTMLElement)"
          >{{ component?.config?.adminLabel || slugToStr(component?.type) }}
        </span>
        <font-awesome-icon
          @click="focusOnAdminLabel"
          :icon="['fas', 'pen-to-square']"
          class="cursor-pointer"
          title="Rename Module"
          width="15"
          height="15"
          fill="currentColor" />
      </h3>
    </div>
    <div class="p-4">
      <component
        :is="`${componentToLoad}-settings`"
        :type="component.type"
        :component="component" />
    </div>
  </buildy-stack>
</template>
<style lang="scss">
.stack-content .tab-content {
  padding-bottom: 32px;
}
</style>
