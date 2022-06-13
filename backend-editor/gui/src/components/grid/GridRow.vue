<script lang="ts" setup>
import { ref } from "vue";
const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  rows: {
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
</script>

<template lang="">
  <div class="bg-100 shadow-sm border-teal-200 d-flex" style="--bs-columns: 3">
    <div class="sortable-handle absolute top-0 left-0 h-full"></div>
    <div class="grid p-3 flex-grow-1">
      <template v-for="column in columns" :key="column.uuid">
        <grid-column :component="column" />
      </template>
    </div>
    <!--<module-controls
      class="transition-all duration-200 text-green-light absolute right-1 bottom-1 mx-auto"
      direction="row"
      :component="row"
      :value="rows"
      :index="rowIndex"
    /> -->
  </div>
</template>

<style lang=""></style>
