<script setup lang="ts">
import { ref, watch } from "vue"
import { useStacks } from "./components/stacks/useStacks"

const contentEl = document.getElementById("content")
const builder = ref<{ [key: string]: any }[]>([])

const { getStacks } = useStacks()

if (contentEl && contentEl.innerText) {
  builder.value = [JSON.parse(contentEl.innerText)]
}

const toggleModuleSelection = ref(false)

watch(
  builder,
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
        v-if="builder.length"
        :component="builder[0]"
        :columns="builder"
        :component-index="0"
        :custom-settings="{ clone: false }"
        :parent-array="builder" />
      <button
        v-else
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
          <module-selector :disable-globals="true" :parent-array="builder" />
        </div>
      </buildy-stack>
    </div>
  </div>
</template>
