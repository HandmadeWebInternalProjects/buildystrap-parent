<script setup lang="ts">
import { ref, watch } from "vue"
import { usePost } from "@/composables/usePost"
import { activePreview } from "@/composables/usePreview"

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
})
const { post }: { post: any } = usePost(props?.moduleItem?.id, props.postType)
const showPreviewDialog = ref<any>(null)
const previewWindow = ref<HTMLIFrameElement | null>(null)

const scrollPreview = ($event: MouseEvent) => {
  // Scroll the preview window iframe based on the mouse position over it
  if (previewWindow.value) {
    const dialog = showPreviewDialog.value
    const dialogRect = dialog.getBoundingClientRect()
    const dialogWidth = dialogRect.width
    const dialogHeight = dialogRect.height

    const iframe = previewWindow.value
    const iframeRect = iframe.getBoundingClientRect()
    const iframeWidth = iframeRect.width

    const x = $event.clientX - dialogRect.left
    const y = $event.clientY - dialogRect.top

    const xPercent = x / dialogWidth / 3
    const yPercent = y / dialogHeight / 3

    const xTranslate = (iframeWidth - dialogWidth) * xPercent
    const yTranslate =
      yPercent *
      ((iframe && iframe.contentWindow?.document?.body?.scrollHeight) ?? 0)

    iframe.style.transform = `translate(${-xTranslate}px, ${-yTranslate}px)`
  }
}

watch(activePreview, (val) => {
  if (val !== post?.value?.id) {
    showPreviewDialog.value.close()
  } else {
    showPreviewDialog.value.show()
  }
})
</script>

<template>
  <div v-if="post" class="position-relative">
    <dialog
      @mouseover="scrollPreview($event)"
      @mousemove="scrollPreview($event)"
      class="preview-dialog"
      ref="showPreviewDialog">
      <iframe
        ref="previewWindow"
        v-show="activePreview === post.id"
        loading="lazy"
        :src="`https://playgroup.local/builder/render-module-previews/?id=${post.id}`"
        style="pointer-events: none" />
    </dialog>
    <module-selection-pill
      :module-item="moduleItem"
      :handle="handle"
      @mouseenter="activePreview = post.id" />
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
  max-height: 15rem;
  padding: 0;
  border-radius: var(--bs-border-radius-lg);
  overflow: hidden;
  iframe {
    width: 100vw;
    height: 100vh;
    object-fit: contain;
  }
}
</style>
