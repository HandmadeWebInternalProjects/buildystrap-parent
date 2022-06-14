<script lang="ts" setup>
import { ref } from "vue";
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
const componentIndex = ref(props.componentIndex);
</script>
<template>
  <div class="bg-700 shadow-sm text-white text-center rounded-1 p-2">
    <span>{{ component.type }}</span>
    <module-controls
      class="justify-content-center px-3 py-2 text-200"
      direction="row"
      :component="component"
      :value="columns"
      :index="componentIndex"
    />
  </div>
</template>
<style lang=""></style>
