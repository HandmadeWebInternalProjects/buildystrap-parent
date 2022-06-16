<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
});

const modules = ref(props.component?.modules);
</script>

<template>
  <div
    class="border border-dashed border-400 border-2 w-full d-flex flex-column p-3 justify-content-center gap-3"
  >
    <draggable
      :list="modules"
      group="modules"
      handle=".sortable-handle"
      item-key="uuid"
      class="section-draggable h-100 d-flex flex-grow flex-column gap-3 group"
    >
      <template #item="{ element, index }">
        <module-base
          :component="element"
          :columns="modules"
          :component-index="index"
        />
      </template>
      <template #footer>
        <button class="btn btn-outline-secondary mx-auto btn-sm">
          <font-awesome-icon
            :icon="['fas', 'plus-circle']"
            width="15"
            height="15"
            fill="currentColor"
            class="cursor-pointer pulse"
          ></font-awesome-icon>
          Add Module
        </button></template
      >
    </draggable>
  </div>
</template>

<style lang=""></style>
