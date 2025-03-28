<script lang="ts" setup>
import { ref, computed, onMounted, onUnmounted } from "vue"
import { useBuilderStore } from "../../stores/builder"
import { storeToRefs } from "pinia"
import { slugToStr } from "../../utils/helpers"
const { registeredComponents, setBuilderContent, toggleIsEditing } = useBuilderStore()

const { builderContent } = storeToRefs(useBuilderStore());

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

const confirm = ref<HTMLDialogElement | null>(null)

const settingsToggle = ref(true)
const builderSnapshot = ref<any>(null)
const component = ref(props.component)
const adminLabelEl = ref<HTMLElement | null>(null)

toggleIsEditing(true)

// Check if a vue component exists that provides custom settings, else use module settings (default)
const componentToLoad = computed((): string => {
  return registeredComponents[component.value.type] ||
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
  settingsToggle.value = false
  toggleIsEditing(false)
  emit("close", true)
}

const handleCancel = () => {
  setBuilderContent(builderSnapshot.value)
  handleClose()
}

const checkDirty = () => {
  if (
    JSON.stringify(builderSnapshot.value) !==
    JSON.stringify(builderContent.value)
  ) {
    confirm?.value?.showModal()
    confirm?.value?.addEventListener(
      "close",
      () => {
        const returnValue = confirm.value?.returnValue
        switch (returnValue) {
          case "save":
            handleClose()
            break
          case "discard":
            handleCancel()
            break
          case "cancel":
            break
        }
      },
      { once: true }
    )
  } else {
    handleClose()
  }
}

onMounted(() => {
  builderSnapshot.value = JSON.parse(JSON.stringify(builderContent.value))
})
</script>
<template>
  <dialog
    ref="confirm"
    class="confirm-dialog border-0 shadow-lg rounded-3 bg-light">
    <form method="dialog" class="p-4 d-flex flex-column align-items-center">
      <h3 class="mb-4 text-body">Are you sure?</h3>
      <p class="mb-4 text-body">
        You have unsaved changes. Do you want to save them?
      </p>
      <div class="d-flex gap-2">
        <button
          class="btn bg-indigo-500 text-white"
          value="save"
          @click="handleClose">
          Save
        </button>
        <button class="btn btn-danger" value="discard">Discard Changes</button>
        <button class="btn border-indigo-500 text-indigo-500" value="cancel">
          Continue Editing
        </button>
      </div>
    </form>
  </dialog>
  <buildy-stack
    :beforeClose="checkDirty"
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
          @click="handleClose">
          Save
        </button>
        <button class="btn text-danger" type="button" @click="handleCancel">
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

.confirm-dialog {
  &::backdrop {
    animation: fadeIn 0.3s ease-in-out forwards;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
  }
}
</style>
