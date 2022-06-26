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
    component.value.type === "section"
    ? component.value.type
    : "module"
})

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
    <div class="p-5">
      <component
        :is="`${componentToLoad}-settings`"
        :type="component.type"
        :component="component" />
    </div>
  </buildy-stack>
</template>
<style lang=""></style>
