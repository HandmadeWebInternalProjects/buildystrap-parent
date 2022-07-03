<script lang="ts" setup>
import { ref, computed } from "vue"

import { useBuilderStore } from "../../stores/builder"
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

// Check if a vue component exists that provides custom settings, else use module settings (default)
const componentToLoad = computed((): string => {
  return getRegisteredComponents[component.value.type] ||
    component.value.type === "row" ||
    component.value.type === "section" ||
    component.value.type === "global-module"
    ? component.value.type
    : "module"
})

const settingsToggle = ref(false)
const designToggle = ref(false)

const inline = ref(component.value?.inline || {})
const attributes = ref(component.value?.attributes || {})
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
      <h3 class="mb-0">Edit {{ component.type }}</h3>
    </div>
    <div class="p-4 h-100">
      <ul class="nav nav-pills border-bottom" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link active"
            data-bs-toggle="tab"
            data-bs-target="#content-tab"
            type="button"
            role="tab"
            aria-controls="content"
            aria-selected="true">
            Content
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#design-tab"
            type="button"
            role="tab"
            aria-controls="design"
            aria-selected="false">
            Design
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#settings-tab"
            type="button"
            role="tab"
            aria-controls="settings"
            aria-selected="false">
            Settings
          </button>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content h-100 card mt-4 p-4 rounded">
        <div
          class="tab-pane active"
          id="content-tab"
          role="tabpanel"
          aria-labelledby="content-tab"
          tabindex="0">
          <component
            :is="`${componentToLoad}-settings`"
            :type="component.type"
            :component="component" />
        </div>
        <div
          class="tab-pane"
          id="design-tab"
          role="tabpanel"
          aria-labelledby="design-tab"
          tabindex="0">
          <design-tab-settings v-model="inline" />
        </div>
        <div
          class="tab-pane"
          id="settings-tab"
          role="tabpanel"
          aria-labelledby="settings-tab"
          tabindex="0">
          <settings-tab-settings v-model="attributes" />
        </div>
      </div>
    </div>
  </buildy-stack>
</template>
<style lang=""></style>
