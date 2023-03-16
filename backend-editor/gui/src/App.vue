<script setup lang="ts">
import { computed, ref, watch } from "vue"
import { storeToRefs } from "pinia"
import { useStacks } from "./components/stacks/useStacks"
import { useBuilderStore } from "./stores/builder"
import { useClipboard } from "./composables/useClipboard"
import { fetchPost, fetchLibraryPost } from "@/services/post"
import { recursifyID } from "./utils/id"

const {
  getGlobalSections,
  getGlobalModules,
  getLibrarySections,
  builderContent,
} = storeToRefs(useBuilderStore())

const { setBuilderContent } = useBuilderStore()

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
} = useClipboard(builderContent)

const globalStackOpen = ref(false)
const libraryStackOpen = ref(false)
const revealGlobalModules = ref(false)

const liveToast = ref(null)

const { getStacks } = useStacks()

if (contentEl && contentEl.innerText) {
  const content = JSON.parse(contentEl.innerText)
  builderContent.value = content
  setBuilderContent(content)
}

const addSection = () => {
  const newModule = createModule("Section", {})
  builderContent.value.push(newModule)
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
  builderContent.value.push(newModule)
}

const addLibrarySection = async (librarySection: {
  id: string
  title: string
}) => {
  const { data } = await fetchLibraryPost(librarySection.id)

  const postContent = JSON.parse(data.post_content)

  postContent.forEach((section: any) => {
    recursifyID(section)
    builderContent.value.push(section)
  })
}

const pastePage = (fromClipBoard: any): void => {
  recursifyID(fromClipBoard)
  // Ask for confirmation prompt before replacing value

  return (builderContent.value = fromClipBoard)
}

watch(
  builderContent,
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
      :list="builderContent"
      :key="builderContent"
      handle=".sortable-handle"
      group="sections"
      item-key="uuid"
      class="section-draggable d-flex flex-grow flex-column gap-3 group bg-white px-3">
      <template #item="{ element, index }">
        <component
          :is="`grid-${element.type}`"
          :section-index="index"
          :parent-array="builderContent"
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
        class="btn btn-sm btn-purple text-white mb-3 me-3"
        @click="libraryStackOpen = true">
        Get from Library
      </button>
      <button
        type="button"
        class="btn btn-sm bg-indigo-500 text-white mb-3 me-3"
        @click="addSection()">
        Add Section
      </button>
    </div>
    <buildy-stack
      class="overflow-visible"
      @close="globalStackOpen = false"
      v-if="globalStackOpen"
      half
      name="module-selector">
      <div
        @click.shift="revealGlobalModules = !revealGlobalModules"
        class="p-4 py-5">
        <h3>Global Sections</h3>
        <module-selection-pill-with-preview
          v-for="globalSection in getGlobalSections"
          :key="globalSection.id"
          @click="addGlobalSection(globalSection)"
          :module-item="globalSection"
          :handle="globalSection.id"
          preview-type="html"
          post-type="buildy-global" />
        <div class="mt-4" v-if="revealGlobalModules">
          <h5>Global Modules</h5>
          <module-selection-pill
            v-for="globalModule in getGlobalModules"
            :key="globalModule.id"
            @click="addGlobalSection(globalModule)"
            :module-item="globalModule"
            :handle="globalModule.id" />
        </div>
      </div>
    </buildy-stack>
    <buildy-stack
      class="overflow-visible"
      @close="libraryStackOpen = false"
      v-if="getLibrarySections.length && libraryStackOpen"
      half
      name="module-selector">
      <div
        @click.shift="revealGlobalModules = !revealGlobalModules"
        class="p-4 py-5">
        <h3>Library Sections</h3>
        <module-selection-pill-with-preview
          v-for="librarySection in getLibrarySections"
          @click="addLibrarySection(librarySection)"
          :key="librarySection.id"
          :module-item="librarySection"
          :handle="librarySection.id"
          preview-type="html"
          post-type="buildy-library" />
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
