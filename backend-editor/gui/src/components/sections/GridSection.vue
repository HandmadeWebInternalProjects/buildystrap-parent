<script lang="ts" setup>
import { ref, computed } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  parentArray: {
    type: Array,
    required: true,
  },
  sectionIndex: {
    type: Number,
    required: true,
  },
});

const section = ref(props.component || {});
const parentArray = ref(props.parentArray || []);
const sectionIndex = computed(() => props.sectionIndex || 0);
const rows = ref(props.component?.rows);
</script>

<template>
  <div class="buildy-section d-flex bg-200 rounded">
    <div class="sortable-handle absolute top-0 left-0 h-full bg-indigo-500 rounded-start">
      <module-controls
        class="align-self-start justify-content-end text-white"
        direction="column"
        :component="section"
        :value="parentArray"
        :index="sectionIndex"
      />
    </div>
    <div class="flex-grow-1">
      <draggable
        :list="rows"
        group="rows"
        handle=".sortable-handle"
        item-key="uuid"
        class="section-draggable d-flex flex-grow-1 p-3 flex-grow flex-column gap-3 group"
      >
        <template #item="{ element, index }">
          <grid-row
            :row-index="index"
            :parent-array="rows"
            :component="element"
          />
        </template>
      </draggable>
    </div>
  </div>
</template>

<style lang=""></style>