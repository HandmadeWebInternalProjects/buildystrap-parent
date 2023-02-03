<script setup lang="ts">
import { ref, watch, onMounted } from "vue"
import { storeToRefs } from "pinia"
import { useStacks } from "./components/stacks/useStacks"
import { useBuilderStore } from "./stores/builder"
import { useClipboard } from "./composables/useClipboard"
import { recursifyID } from "./utils/id"

const { getGlobalSections, getGlobalModules } = storeToRefs(useBuilderStore())

// @ts-ignore
import {
  // @ts-ignore
  createModule,
  // @ts-ignore
  type ModuleType,
  // @ts-ignore
} from "@/factories/modules/moduleFactory"

const contentEl = document.getElementById("content")
const builder = ref<ModuleType[]>([])

const {
  readFromClipboard,
  hasClipboardAccess,
  copyPageToClipboard,
  pasteFromClipboard,
  isValidPasteLocation,
} = useClipboard(builder)

const globalStackOpen = ref(false)
const revealGlobalModules = ref(false)

const liveToast = ref(null)

const { getStacks } = useStacks()

if (contentEl && contentEl.innerText) {
  builder.value = JSON.parse(contentEl.innerText)
}

const addSection = () => {
  const newModule = createModule("Section", {})
  builder.value.push(newModule)
}

const addGlobalSection = (globalSection: { id: number; title: string }) => {
  const VALUE = globalSection.id
  const ADMIN_LABEL = globalSection.title
  const TYPE = "GlobalSection"
  const newModule = createModule("GlobalSection", {
    ADMIN_LABEL,
    TYPE,
    VALUE,
  })
  builder.value.push(newModule)
  console.log({ newModule })
}

const pastePage = (fromClipBoard: any): void => {
  recursifyID(fromClipBoard)
  // Ask for confirmation prompt before replacing value

  return (builder.value = fromClipBoard)
}

watch(
  builder,
  (newValue) => {
    contentEl && (contentEl.innerText = JSON.stringify(newValue))
  },
  {
    deep: true,
  }
)
</script>

<template>
  <stacks v-if="getStacks.length"></stacks>
  <div class="d-flex flex-column rounded gap-3 m-0 mb-6 px-0 bg-white">
    <buildy-header title="Buildystrap" />
    <draggable
      :list="builder"
      handle=".sortable-handle"
      group="sections"
      item-key="uuid"
      class="section-draggable d-flex flex-grow flex-column gap-3 group bg-white px-3">
      <template #item="{ element, index }">
        <component
          :is="`grid-${element.type}`"
          :section-index="index"
          :parent-array="builder"
          :component="element" />
      </template>
    </draggable>
    <div class="d-flex ms-auto">
      <button
        v-if="isValidPasteLocation"
        type="button"
        class="btn btn-sm btn-danger text-white mb-3 me-3"
        @click="pasteFromClipboard(pastePage)">
        Paste page from clipboard
      </button>
      <button
        type="button"
        class="btn btn-sm btn-warning text-white mb-3 me-3"
        @click="copyPageToClipboard">
        Copy Page To Clipboard
      </button>
      <button
        v-if="hasClipboardAccess"
        type="button"
        class="btn btn-sm btn-secondary text-white mb-3 me-3"
        @click="readFromClipboard(liveToast)">
        Paste from clipboard
      </button>
      <button
        type="button"
        class="btn btn-sm btn-purple text-white mb-3 me-3"
        @click="globalStackOpen = true">
        Add Global Section
      </button>
      <button
        type="button"
        class="btn btn-sm bg-indigo-500 text-white mb-3 me-3"
        @click="addSection()">
        Add Section
      </button>
    </div>
    <buildy-stack
      @close="globalStackOpen = false"
      v-if="globalStackOpen"
      half
      name="module-selector">
      <div
        @click.shift="revealGlobalModules = !revealGlobalModules"
        class="p-4 py-5">
        <h3>Global Sections</h3>
        <div
          v-for="globalSection in getGlobalSections"
          @click="addGlobalSection(globalSection)"
          :key="globalSection.id"
          class="border bg-700 text-white cursor-pointer transition-all scale-md-hover w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm">
          {{ globalSection.title }}
        </div>
        <div class="mt-4" v-if="revealGlobalModules">
          <h5>Global Modules</h5>
          <div
            v-for="globalModule in getGlobalModules"
            @click="addGlobalSection(globalModule)"
            :key="globalModule.id"
            class="border bg-700 text-white cursor-pointer transition-all scale-md-hover w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm">
            {{ globalModule.title }}
          </div>
        </div>
      </div>
    </buildy-stack>
  </div>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div
      ref="liveToast"
      class="toast"
      role="alert"
      aria-live="assertive"
      aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Buildystrap</strong>
        <small>Ready to paste</small>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Now choose where you would like to paste the module by clicking one of
        the highlighted icons above, your module will be pasted right underneath
        the one you choose.
      </div>
    </div>
  </div>
</template>

<style lang="scss">
@import "./scss/app.scss";
</style>
