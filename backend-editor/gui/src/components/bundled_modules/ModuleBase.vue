<script lang="ts" setup>
import { ref, computed } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
  columns: {
    type: Array,
    required: true,
  },
  componentIndex: {
    type: Number,
    required: true,
  },
});

const component = ref(props.component);
const columns = ref(props.columns);
const componentIndex = computed((): number => props.componentIndex);
</script>
<template>
  <div class="bg-700 shadow-sm text-white rounded-1 d-flex">
    <div class="sortable-handle absolute top-0 left-0 h-full"></div>
    <div class="d-flex flex-column align-items-center flex-grow-1">
      <span class="d-block py-1">{{ component.type }}</span>
      <module-controls
        class="justify-content-center px-3 text-200"
        direction="row"
        :component="component"
        :value="columns"
        :index="componentIndex"
      />
    </div>
  </div>
</template>
<style lang=""></style>
