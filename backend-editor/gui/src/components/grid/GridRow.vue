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
  rowIndex: {
    type: Number,
    required: true,
  },
});

const columns = ref(props.component?.columns || []);
const row = ref(props.component);
const parentArray = ref(props.parentArray);
const rowIndex = computed(() => props.rowIndex);
</script>

<template>
  <div class="bg-100 shadow-sm border-teal-200 d-flex" style="--bs-columns: 3">
    <div class="sortable-handle absolute top-0 left-0 h-full"></div>
    <div class="flex-grow-1">
      <div class="grid p-3 pb-0">
        <template v-for="column in columns" :key="column.uuid">
          <grid-column :component="column" />
        </template>
      </div>
      <module-controls
        class="justify-content-end px-3 py-2 text-600"
        direction="row"
        :component="row"
        :value="parentArray"
        :index="rowIndex"
      />
    </div>
  </div>
</template>

<style lang=""></style>
