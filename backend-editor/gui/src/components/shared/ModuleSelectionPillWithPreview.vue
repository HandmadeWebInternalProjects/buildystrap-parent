<script setup lang="ts">
import { ref } from "vue"
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
})
const { post }: { post: any } = usePost(props?.moduleItem?.id, props.postType)
const loadIframe = ref(false)

const showPreviewDialog = ref<any>(null)
const openPreview = () => {
  if (!loadIframe.value) {
    loadIframe.value = true
  }
  showPreviewDialog?.value?.show()
}
const closePreview = () => {
  showPreviewDialog?.value?.close()
}
</script>

<template>
  <div v-if="post" class="position-relative">
    <dialog class="preview-dialog" ref="showPreviewDialog">
      <iframe
        v-if="loadIframe"
        width="1000"
        loading="lazy"
        height="300"
        :src="`https://playgroup.local/builder/render-module-previews/?id=${post.id}`" />
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
  overflow: hidden;
  iframe {
    // width: 100%;
    object-fit: contain;
  }
}
</style>
