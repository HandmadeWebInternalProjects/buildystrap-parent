<script setup lang="ts">
import { ref, onMounted } from "vue"
import { usePost } from "@/composables/usePost"

const props = defineProps({
  moduleItem: {
    type: Object,
    required: true,
  },
  handle: {
    type: String,
    required: true,
  },
  postType: {
    type: String,
    required: true,
  },
  previewType: {
    type: String,
    default: "html",
  },
})
const { post, featuredImageURL, renderPostModule } = usePost(
  props?.moduleItem?.id,
  props.postType
)

const html = ref(null)

onMounted(async () => {
  if (props.previewType === "html") {
    html.value = await renderPostModule()
  }
})

const showPreviewDialog = ref<HTMLDialogElement | null>(null)
const openPreview = () => {
  showPreviewDialog?.value?.show()
}
const closePreview = () => {
  showPreviewDialog?.value?.close()
}
</script>

<template>
  <div class="position-relative">
    <dialog
      v-if="previewType === 'html'"
      class="preview-dialog"
      ref="showPreviewDialog">
      <span v-html="html" />
    </dialog>
    <dialog
      v-else-if="featuredImageURL"
      class="preview-dialog"
      ref="showPreviewDialog">
      <img :src="featuredImageURL" />
    </dialog>
    <module-selection-pill
      :module-item="moduleItem"
      :handle="handle"
      @mouseenter="openPreview"
      @mouseleave="closePreview" />
  </div>
</template>

<style lang="scss">
.preview-dialog {
  position: absolute;
  left: 0;
  right: unset;
  transform: translateX(-102%);
  width: 100%;
  max-width: 30rem;
  padding: 0;
  border-radius: var(--bs-border-radius-lg);
  img {
    width: 100%;
    object-fit: contain;
  }
}
</style>
