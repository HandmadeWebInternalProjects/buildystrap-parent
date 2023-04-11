<template lang="">
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <div
      @click.prevent="openMediaLibrary"
      class="flex w-full position-relative cursor-pointer items-center justify-center image-selector border border-dashed border-2 rounded p-3"
      :class="[images ? 'hasImage' : 'empty']">
      <draggable
        class="d-flex flex-wrap gap-3"
        :class="[
          {
            '': config.multiple && images.length,
          },
        ]"
        :list="images"
        item-key="id">
        <template #item="{ element }">
          <div class="image-preview-wrapper position-relative">
            <async-img
              :id="element.id"
              class="image-preview w-100 aspect-square" />

            <font-awesome-icon
              v-if="images.length"
              :icon="['fas', 'trash-alt']"
              @click.stop="removeImage(element.id)"
              class="remove-image-icon"></font-awesome-icon>
          </div>
        </template>
      </draggable>
      <div class="d-flex flex-wrap gap-3" v-if="placeholder?.length">
        <div class="image-preview-wrapper position-relative">
          <async-img
            v-for="phId in placeholder"
            :key="phId.id"
            :id="phId.id"
            class="image-preview image-placeholder opacity-50 aspect-square" />
        </div>
      </div>
      <input
        v-if="!images.length && !placeholder?.length"
        class="form-control pointer-events-none"
        type="file" />
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, toRefs, onUnmounted, computed, nextTick } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, placeholder } = toRefs(props)

type MediaType = {
  id: number
}

const images = computed({
  get() {
    return props?.modelValue || props?.value || []
  },
  set(value) {
    update(value)
  },
})

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

let libraryRef: any = null

const initMediaLibrary = () => {
  if (window?.wp?.media) {
    libraryRef = window.wp.media({
      // Accepts [ 'select', 'post', 'image', 'audio', 'video' ]
      // Determines what kind of library should be rendered.
      frame: "select",
      // Modal title.
      title: "Select Images",
      // Enable/disable multiple select
      multiple: config.value.multiple || false,
      // Library wordpress query arguments.
      defaultContent: "library",
      library: {
        order: "DESC",
        // [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
        orderby: "date",
        // mime type. e.g. 'image', 'image/jpeg'
        // type: "image",
        // Searches the attachment title.
        // search: false,
        // Includes media only uploaded to the specified post (ID)
        // uploadedTo: window.wp.media.view.settings.post.id, // wp.media.view.settings.post.id (for current post ID)
      },
      button: {
        text: "Done",
      },
    })
  }
  if (libraryRef) {
    libraryRef.on("select", () => {
      var selectedImages = libraryRef.state().get("selection")
      let selection = selectedImages.map((attachment: any) => {
        attachment = attachment.toJSON()
        return {
          id: attachment.id,
        }
      })
      images.value = selection
      // console.log("selection", selection)
    })

    libraryRef.on("open", () => {
      let selection = libraryRef.state().get("selection")
      if (images.value.length) {
        images.value.forEach((image: MediaType) => {
          if (image.id) {
            let attachment = image.id && window.wp.media.attachment(image.id)
            if (attachment) {
              attachment.fetch()
              selection.add([attachment])
            }
          }
        })
      }
    })
    libraryRef.open()
  }
}

const openMediaLibrary = async () => {
  if (libraryRef) {
    libraryRef.open()
    return
  } else {
    initMediaLibrary()
  }
}

const removeImage = (image: number) => {
  update(images.value.filter((el: MediaType) => el.id !== image))
}

onUnmounted(() => {
  if (libraryRef) {
    libraryRef.detach()
  }
})
</script>
<style lang="scss">
.image-selector input {
  font-size: 0.9em !important;
}
.image-preview-wrapper {
  width: calc(16.6667% - 1rem);
}
.image-preview {
  img {
    border-radius: 5px;
  }
}
.remove-image-icon {
  position: absolute;
  top: 0.4rem;
  right: 0.4rem;
  cursor: pointer;
  padding: 7.5px;
  background: var(--bs-indigo);
  font-size: 1.8rem;
  color: white;
  z-index: 100;
  border-radius: 50%;
}
</style>
