<template lang="">
  <div>
    <field-label :label="config?.label !== undefined ? config.label : handle" />
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
          <div
            class="position-relative"
            :class="[config.multiple ? 'w-25' : 'w-100']">
            <img
              :id="`img-${element.id}` + handle"
              class="image-preview w-100 h-100"
              :src="element.url" />
            <font-awesome-icon
              v-if="images.length"
              :icon="['fas', 'trash-alt']"
              @click.stop="removeImage(element)"
              class="remove-image-icon"></font-awesome-icon>
          </div>
        </template>
      </draggable>
      <input
        v-if="!images.length"
        class="form-control pointer-events-none"
        type="file" />
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, toRefs, onMounted, computed } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

type MediaType = { id: string; url: string }

const { handle, config } = toRefs(props)

const images = computed({
  get() {
    return props.modelValue || []
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
        let imageData = {
          url: attachment.url,
          id: attachment.id,
        }

        return imageData
      })
      images.value = selection
    })

    libraryRef.value.on("open", () => {
      let selection = libraryRef.value.state().get("selection")
      if (images.value.length) {
        images.value.forEach((image: MediaType) => {
          if (image.id) {
            let id = image.id
            let attachment = id && window.wp.media.attachment(id)
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

const removeImage = (image: MediaType) => {
  update(images.value.filter((el: MediaType) => el.id !== image.id))
}

onMounted(() => {
  initMediaLibrary()
})
</script>
<style lang="scss">
.image-preview {
  max-height: 200px;
  object-fit: cover;
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
