<script lang="ts" setup>
import { toRefs, ref, watch, reactive } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { getImageSizes } = useBuilderOptions()
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const fields: any = reactive({
  image: ref(modelValue?.value?.image || []),
  object_fit: ref(modelValue?.value?.object_fit || ""),
  object_position: ref(modelValue?.value?.object_position || ""),
  width: ref(modelValue?.value?.width || ""),
  height: ref(modelValue?.value?.height || ""),
  max_width: ref(modelValue?.value?.max_width || ""),
  max_height: ref(modelValue?.value?.max_height || ""),
  image_size: ref(modelValue?.value?.image_size || ""),
})

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

watch(fields, (newValue) => {
  update(newValue)
})
</script>

<template>
  <bs-card :label="config?.label !== undefined ? config.label : handle">
    <template v-slot:body>
      <div>
        <media-field
          handle="image"
          :config="{ multiple: false }"
          v-model="fields.image" />
      </div>

      <div class="d-flex gap-4">
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="object_fit"
          :config="{
            label: 'Object Fit',
            options: ['contain', 'cover', 'fit', 'fill'],
            popover: 'Choose how the image should fit within the container.',
            placeholder: 'Default',
          }"
          v-model="fields.object_fit" />
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="object_position"
          :config="{
            label: 'Object Position',
            options: [
              { value: 'left', label: 'Left' },
              { value: 'left-top', label: 'Left Top' },
              { value: 'left-bottom', label: 'Left Bottom' },
              { value: 'right', label: 'Right' },
              { value: 'right-top', label: 'Right Top' },
              { value: 'right-bottom', label: 'Right Bottom' },
              { value: 'center', label: 'Center' },
              { value: 'center-top', label: 'Center Top' },
              { value: 'center-bottom', label: 'Center Bottom' },
            ],
            popover:
              'Choose how the image should be positioned within the container.',
            placeholder: 'Default',
          }"
          v-model="fields.object_position" />
      </div>

      <div class="d-flex gap-4">
        <text-field
          class="flex-grow-1"
          :config="{ label: 'Width' }"
          handle="width"
          v-model="fields.width" />
        <text-field
          class="flex-grow-1"
          handle="height"
          :config="{ label: 'Height' }"
          v-model="fields.height" />
      </div>
      <div class="d-flex gap-4">
        <text-field
          class="flex-grow-1"
          handle="max_width"
          :config="{ label: 'Max Width' }"
          v-model="fields.max_width" />
        <text-field
          class="flex-grow-1"
          handle="max_height"
          :config="{ label: 'Max Height' }"
          v-model="fields.max_height" />
      </div>
      <div>
        <select-field
          class="flex-grow-1 flex-basis-0"
          handle="image_size"
          :config="{
            label: 'WordPress Image Size',
            options: getImageSizes(),
            popover:
              'Optionally choose a WordPress image size (crop) to use for this image.',
            placeholder: 'Default',
          }"
          v-model="fields.image_size" />
      </div>
    </template>
  </bs-card>
</template>

<style lang=""></style>