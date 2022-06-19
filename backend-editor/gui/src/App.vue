<script setup lang="ts">
import { ref, watch } from "vue";
import { useStacks } from "./components/stacks/useStacks";

const contentEl = document.getElementById("content");
const builder = ref([]);

const { getStacks } = useStacks();

if (contentEl && contentEl.innerText) {
  builder.value = JSON.parse(contentEl.innerText);
}

watch(
  builder,
  (newValue) => {
    contentEl && (contentEl.innerText = JSON.stringify(newValue));
  },
  {
    deep: true,
  }
);
</script>

<template>
  <stacks v-if="getStacks.length"></stacks>
  <portal-target name="destination" multiple />

  <div class="container shadow-sm d-flex flex-column rounded gap-3 mt-4 px-0">
    <draggable
      :list="builder"
      handle=".sortable-handle"
      group="sections"
      item-key="uuid"
      class="section-draggable d-flex flex-grow flex-column gap-3 group"
    >
      <template #item="{ element, index }">
        <component
          :is="`grid-${element.type}`"
          :section-index="index"
          :parent-array="builder"
          :component="element"
        />
      </template>
    </draggable>
  </div>
</template>

<style lang="scss">
@import "./scss/app.scss";

#app {
  padding-top: 1rem;
}

.sortable-handle {
  width: 1rem;
  padding: 8px;
  cursor: -webkit-grab;
  cursor: grab;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background: $gray-600;
  border-right: 1px solid $gray-800;
  &::before {
    width: 12px;
    height: 24px;
    content: "";
    display: block;
    background-image: radial-gradient($gray-400 0.05rem, transparent 0);
    background-repeat: both;
    background-size: 6px 6px;
    background-position: 1px -1px;
    position: absolute;
  }
}
</style>
