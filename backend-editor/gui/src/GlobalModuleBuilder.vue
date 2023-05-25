<script setup lang="ts">
import { ref, watch } from "vue"
import { storeToRefs } from "pinia"
import { useStacks } from "./components/stacks/useStacks"
import { useBuilderStore } from "./stores/builder"
import { useClipboard } from "./composables/useClipboard"

const contentEl = document.getElementById("content")
const builder = ref<{ [key: string]: any }[]>([])
const { builderContent } = storeToRefs(useBuilderStore())

const { getStacks } = useStacks()

if (contentEl && contentEl.innerText) {
  builderContent.value = [JSON.parse(contentEl.innerText)]
}


const { readFromClipboard, hasClipboardAccess } = useClipboard(builderContent)

const toggleModuleSelection = ref(false)

watch(
  builderContent,
  (newValue) => {
    contentEl && (contentEl.innerText = JSON.stringify(newValue[0]))
  },
  {
    deep: true,
  }
)
</script>

<template>
  <stacks v-if="getStacks.length"></stacks>
  <div class="container d-flex flex-column rounded gap-3 mt-4 px-0 pb-5">
    <buildy-header title="Buildystrap" />
    <div class="section p-4 bg-300">
      <module-base
        v-for="(builderModule, index) in builderContent"
        :key="builderModule.id"
        :component="builderModule"
        :columns="builderContent"
        :component-index="0"
        :index="index"
        :custom-settings="{ clone: false }"
        :parent-array="builderContent" />
      <button
        v-if="!builderContent.length"
        @click="toggleModuleSelection = !toggleModuleSelection"
        type="button"
        class="bg-200 w-100 text-800 border-0 rounded-1">
        <font-awesome-icon
          :icon="['fas', 'plus-circle']"
          width="25"
          height="25"
          fill="currentColor"
          class="cursor-pointer pulse"></font-awesome-icon>
      </button>
      <buildy-stack
        @close="toggleModuleSelection = false"
        v-if="toggleModuleSelection"
        narrow
        name="module-selector">
        <div class="p-4 py-5">
          <module-selector :disable-globals="true" :parent-array="builderContent" />
        </div>
      </buildy-stack>
    </div>
    <div class="d-flex ms-auto">
      <button
        v-if="hasClipboardAccess"
        type="button"
        class="btn btn-sm btn-secondary text-white mb-3 me-3"
        @click="readFromClipboard()">
        Paste from clipboard
      </button>
    </div>
  </div>
</template>
