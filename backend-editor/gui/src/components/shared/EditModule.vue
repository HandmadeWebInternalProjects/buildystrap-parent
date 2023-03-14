<script lang="ts" setup>
import { ref, computed, onMounted } from "vue"
import { useBuilderStore } from "../../stores/builder"
import { storeToRefs } from "pinia"
import { slugToStr } from "../../utils/helpers"
import type { EventInterface } from "../Events"
const { getRegisteredComponents, setBuilderContent } = useBuilderStore()

const { getBuilderContent } = storeToRefs(useBuilderStore())

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

const emit = defineEmits<{
  (event: "close", boolean: boolean): void
}>()

const settingsToggle = ref(true)
const builderSnapshot = ref<any>(null)
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

const handleClose = () => {
  if (
    JSON.stringify(builderSnapshot.value) !==
    JSON.stringify(getBuilderContent.value)
  ) {
    if (confirm("You have unsaved changes. Are you sure you want to close?")) {
      setBuilderContent(builderSnapshot.value)
      settingsToggle.value = false
      emit("close", true)
    }
  } else {
    settingsToggle.value = false
    emit("close", true)
  }
}

const handleSave = () => {
  settingsToggle.value = false
  emit("close", true)
}

onMounted(() => {
  builderSnapshot.value = JSON.parse(JSON.stringify(getBuilderContent.value))
})
</script>
<template>
  <buildy-stack
    :beforeClose="handleClose"
    v-if="settingsToggle"
    half
    name="module-settings">
    <div class="tab-header bg-indigo-500 text-white px-4 py-3">
      <h3 class="mb-0 d-flex gap-2">
        Edit
        <span
          class="tab-title block text-capitalize"
          ref="adminLabelEl"
          contenteditable="true"
          @blur="updateAdminLabel($event.target as HTMLElement)"
          >{{ component?.config?.adminLabel || slugToStr(component?.type) }}
        </span>
        <sup>
          <font-awesome-icon
            @click="focusOnAdminLabel"
            :icon="['fas', 'pen-to-square']"
            class="cursor-pointer"
            title="Rename Module"
            width="15"
            height="15"
            fill="currentColor" />
        </sup>
      </h3>
    </div>
    <div class="p-4">
      <component
        :is="`${componentToLoad}-settings`"
        :type="component.type"
        @save="settingsToggle = false"
        @cancel="setBuilderContent($event)"
        :component="component" />
      <div class="d-flex gap-2 mt-4">
        <button
          class="btn bg-indigo-500 text-white"
          type="button"
          @click="handleSave">
          Save
        </button>
        <button class="btn text-danger" type="button" @click="handleSave">
          Cancel
        </button>
      </div>
    </div>
  </buildy-stack>
</template>
<style lang="scss">
.stack-content {
  .tab-header {
    .tab-title {
      border-radius: 5px;

      &:focus-visible {
        outline: 1px dashed rgba(255, 255, 255, 0.5);
      }
    }
    sup {
      top: -0.25em !important;
    }
  }
  .tab-content {
    padding-bottom: 32px;
  }
}
</style>
