<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  sections: {
    type: Array,
    required: true,
  },
  sectionIndex: {
    type: Number,
    required: true,
  },
});

const section = ref(props.component || {});
const sections = ref(props.sections || []);
const sectionIndex = ref(props.sectionIndex || 0);
const rows = ref(props.component?.rows);
</script>

<template>
  <div class="buildy-section d-flex bg-200">
    <div class="sortable-handle absolute top-0 left-0 h-full"></div>
    <div class="flex-grow-1">
      <draggable
        :list="rows"
        group="rows"
        handle=".sortable-handle"
        item-key="uuid"
        class="section-draggable d-flex flex-grow-1 p-3 pb-0 flex-grow flex-column gap-3 group"
      >
        <template #item="{ element, index }">
          <grid-row :row-index="index" :rows="rows" :component="element" />
        </template>
      </draggable>
      <module-controls
        class="justify-content-end px-3 py-2 text-800"
        direction="row"
        :component="section"
        :value="sections"
        :index="sectionIndex"
      />
    </div>
  </div>
</template>

<style lang=""></style>
