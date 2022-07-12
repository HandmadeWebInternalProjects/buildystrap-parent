<template lang="">
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <div
      @click.prevent="openMediaLibrary"
      class="flex w-full position-relative cursor-pointer items-center justify-center image-selector"
      :class="[images ? 'hasImage' : 'empty']">
      <draggable
        class="d-flex gap-3"
        :class="[
          {
            'border border-dashed border-2 bg-100 rounded p-3':
              config.multiple && images.length,
          },
        ]"
        :list="images"
        item-key="id">
        <template #item="{ element }">
          <div class="position-relative w-25">
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
      <div
        class="d-flex gap-3"
        :class="[
          {
            'border border-dashed border-2 bg-100 rounded p-3':
              config.multiple && placeholder?.length,
          },
        ]"
        v-if="placeholder?.length">
        <async-img
          v-for="phId in placeholder"
          :key="phId.id"
          :id="phId.id"
          class="image-preview opacity-50 aspect-square w-25" />
      </div>
      <input
        v-if="!images.length && !placeholder?.length"
        class="form-control pointer-events-none"
        type="file" />
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, toRefs, onMounted, computed } from "vue"
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

const libraryRef: any = ref(null)

const initMediaLibrary = () => {
  if (window?.wp?.media) {
    libraryRef.value = window.wp.media({
      // Accepts [ 'select', 'post', 'image', 'audio', 'video' ]
      // Determines what kind of library should be rendered.
      frame: "select",
      // Modal title.
      title: "Select Images",
      // Enable/disable multiple select
      multiple: config.value.multiple || false,
      // Library wordpress query arguments.
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
  if (libraryRef.value) {
    libraryRef.value.on("select", () => {
      var selectedImages = libraryRef.value.state().get("selection")
      let selection = selectedImages.map((attachment: any) => {
        attachment = attachment.toJSON()
        return {
          id: attachment.id,
        }
      })
      console.log({ selection })
      images.value = selection
    })

    libraryRef.value.on("open", () => {
      let selection = libraryRef.value.state().get("selection")
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
  }
}

const openMediaLibrary = () => {
  if (libraryRef.value) {
    libraryRef.value.open()
  } else {
    initMediaLibrary()
    libraryRef.value.open()
  }
}

const removeImage = (image: number) => {
  update(images.value.filter((el: MediaType) => el.id !== image))
}

onMounted(() => {
  initMediaLibrary()
})
</script>
<style lang="scss">
.image-selector input {
  font-size: 0.9em !important;
}
.remove-image-icon {
  position: absolute;
  top: 0.4rem;
  right: 0.4rem;
  cursor: pointer;
  font-size: 1.2rem;
  color: #000;
  z-index: 100;
}
</style>
