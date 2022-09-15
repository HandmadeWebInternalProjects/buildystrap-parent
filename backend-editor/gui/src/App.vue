<script setup lang="ts">
import { ref, watch, onMounted } from "vue"
import { storeToRefs } from "pinia"
import { useStacks } from "./components/stacks/useStacks"
import { useBuilderStore } from "./stores/builder"
import { useClipboard } from "./composables/useClipboard"
const { getGlobalSections } = storeToRefs(useBuilderStore())

const { readFromClipboard } = useClipboard({})

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

const globalStackOpen = ref(false)

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

onMounted(() => {
  navigator?.clipboard ? readFromClipboard() : null
})

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
  <div
    class="container d-flex flex-column rounded gap-3 mt-4 mb-6 px-0 bg-white">
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
        type="button"
        class="btn btn-sm btn-purple text-white mb-3 me-3"
        @click="globalStackOpen = true">
        Add Global Section
      </button>
      <button
        type="button"
        class="btn btn-sm btn-primary mb-3 me-3"
        @click="addSection()">
        Add Section
      </button>
    </div>
    <buildy-stack
      @close="globalStackOpen = false"
      v-if="globalStackOpen"
      half
      name="module-selector">
      <div class="p-4 py-5">
        <h3>Globals</h3>
        <div
          v-for="globalSection in getGlobalSections"
          @click="addGlobalSection(globalSection)"
          :key="globalSection.id"
          class="border bg-700 text-white cursor-pointer transition-all scale-md-hover w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm">
          {{ globalSection.title }}
        </div>
      </div>
    </buildy-stack>
  </div>
</template>

<style lang="scss">
@import "./scss/app.scss";

#app {
  padding-top: 1rem;
}

.sortable-handle {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  width: 35px;
  padding: 10px;
  cursor: -webkit-grab;
  cursor: grab;
  background: $gray-600;

  &:after {
    content: "";
    position: relative;
    display: block;
    min-width: 12px;
    height: 24px;
    margin-top: 10px;
    background-image: radial-gradient($gray-100 0.05rem, transparent 0);
    background-repeat: both;
    background-size: 6px 6px;
  }
  &.handle-single {
    &:after {
      margin-top: 0;
    }
  }
}
</style>
