<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
});
const drag = ref(false);
const modules = ref(props.component?.modules);
const toggleModuleSelection = ref(false);
</script>

<template>
  <div
    class="border border-dashed border-300 border-2 rounded w-full d-flex flex-column p-3 justify-content-center gap-3"
  >
    <draggable
      :list="modules"
      group="modules"
      item-key="uuid"
      class="section-draggable h-100 d-flex flex-grow flex-column gap-3 group"
      :component-data="{
        tag: 'div',
        type: 'transition-group',
        name: !drag ? 'flip-list' : null
      }"
      @start="drag = true"
      @end="drag = false"
    >
      <template #item="{ element, index }">
        <div>
          <module-base
            :component="element"
            :columns="modules"
            :component-index="index"
          />
        </div>
      </template>
    </draggable>
    <button
      @click="toggleModuleSelection = !toggleModuleSelection"
      type="button"
      class="bg-200 text-800 border-0 rounded-1"
    >
      <font-awesome-icon
        :icon="['fas', 'plus-circle']"
        width="25"
        height="25"
        fill="currentColor"
        class="cursor-pointer pulse"
      ></font-awesome-icon>
    </button>
    <buildy-stack
      @close="toggleModuleSelection = false"
      v-if="toggleModuleSelection"
      half
      name="module-selector"
    >
      <div class="p-5">
        <p>Hello from the Module Selector Stack</p>
      </div>
    </buildy-stack>
  </div>
</template>

<style lang="scss">
.sortable-ghost {
  opacity: 0.3;
}
.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
</style>
