<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
});

const rows = ref(props.component?.rows || []);
</script>

<template>
  <div class="buildy-section d-flex bg-200">
    <div class="sortable-handle absolute top-0 left-0 h-full"></div>
    <draggable
      v-model="rows"
      group="rows"
      handle=".sortable-handle"
      item-key="uuid"
      class="section-draggable d-flex flex-grow-1 p-3 flex-grow flex-column gap-3 group"
    >
      <template #item="{ element }">
        <grid-row :key="`row-${element.uuid}`" :component="element" />
      </template>
    </draggable>
  </div>
</template>

<style lang=""></style>
