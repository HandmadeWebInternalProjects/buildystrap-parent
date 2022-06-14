<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
});

const modules = ref(props.component?.modules || []);
</script>

<template>
  <div class="border border-dashed border-400 border-2 w-full">
    <draggable
      v-model="modules"
      group="modules"
      item-key="uuid"
      class="section-draggable h-100 d-flex flex-grow flex-column p-3 gap-3 group"
    >
      <template #item="{ element, index }">
        <module-base
          :component="element"
          :columns="modules"
          :component-index="index"
        />
      </template>
    </draggable>
  </div>
</template>

<style lang=""></style>
