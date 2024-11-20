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
const leaving = ref<number>(0);

const scrollPreview = ($event) => {
  const iframe = previewWindow.value
  if (!iframe) return

  if ($event.type === 'mouseover') {
    if (leaving.value) {
      clearTimeout(leaving.value)
    }
  }

  if ($event.type === 'mouseleave') {
    iframe.style.transform = 'scale(0.6) translate(0, 0)'
    timeout(1000)
    return
  }

  const dialog = showPreviewDialog.value
  const dialogRect = dialog.getBoundingClientRect()
  const x = $event.clientX - dialogRect.left
  const y = $event.clientY - dialogRect.top

  const iframeRect = iframe.getBoundingClientRect()
  const iframeWidth = iframeRect.width * 0.6
  const iframeHeight = iframeRect.height * 0.6

  const translateX = (x / dialogRect.width) * (iframeWidth - dialogRect.width)
  const translateY = (y / dialogRect.height) * (iframeHeight - dialogRect.height)

  iframe.style.transform = `scale(0.6) translate(-${translateX}px, -${translateY}px)`
}

const timeout = (time = 500) => {
  if (leaving.value) {
    clearTimeout(leaving.value)
  }
  leaving.value = setTimeout(() => {
    showPreviewDialog.value.close()
    activePreview.value = null
  }, time);
}

watch(activePreview, (val) => {
  if (val !== post?.value?.id) {
    showPreviewDialog.value.close()
  } else {
    showPreviewDialog.value.show()  }
})
</script>

<template>
  <div v-if="post" class="position-relative">
    <dialog
      @mouseover="scrollPreview($event)"
      @mousemove="scrollPreview($event)"
      @mouseleave="scrollPreview($event)"
      class="preview-dialog"
      ref="showPreviewDialog">
      <iframe
        ref="previewWindow"
        v-show="activePreview === post.id"
        loading="lazy"
        :src="`/builder/render-module-previews/?id=${post.id}`"
        style="pointer-events: none" />
    </dialog>
    <module-selection-pill
      :module-item="moduleItem"
      :handle="handle"
      @mouseenter="activePreview = post.id"/>
  </div>
</template>

<style lang="scss">
.preview-dialog {
  position: absolute;
  right: 0;
  left: unset;
  width: 100%;
  max-width: 60%;
  max-height: 15rem;
  padding: 0;
  border-radius: var(--bs-border-radius-lg);
  overflow: hidden;
  z-index: 10000;
  iframe {
    width: 100vw;
    height: 100vh;
    object-fit: contain;
    transform: scale(0.6);
    transform-origin: top left;
  }
}
</style>
