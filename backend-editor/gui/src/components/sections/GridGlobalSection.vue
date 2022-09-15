<script lang="ts" setup>
import { ref, computed } from "vue"

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
})

const parentArray = ref(props.parentArray || [])
const sectionIndex = computed(() => props.sectionIndex || 0)

const customSettings = {
  // menu: false,
  clone: false,
  goToGlobal: {
    icon: ["fas", "arrow-up-right-from-square"],
    title: "Open settings modal",
    action: () =>
      // check if window has .open method
      window.open
        ? window.open(
            `/wp-admin/post.php?post=${props.component?.global_id}&action=edit&classic-editor`,
            "_blank"
          )
        : (window.location.href = `/wp-admin/post.php?post=${props.component?.global_id}&action=edit&classic-editor`),

    order: 10,
  },
}
</script>

<template>
  <div class="shadow-sm text-white rounded d-flex bg-teal-700">
    <div
      class="sortable-handle handle-single bg-teal-800 align-items-center absolute top-0 left-0 h-full rounded-start"></div>
    <div
      class="d-flex flex-row justify-content-between align-items-center flex-grow-1 px-3 py-2">
      <span
        contenteditable="true"
        class="module-title flex-grow-1 py-1 me-2 text-nowrap overflow-hidden"
        >{{ component?.config?.adminLabel }}</span
      >
      <module-controls
        class="justify-content-center text-white"
        direction="row"
        :component="component"
        :value="parentArray"
        :index="sectionIndex"
        :custom-settings="customSettings" />
    </div>
  </div>
</template>

<style lang=""></style>
