<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { useBreakpoints } from "../../../composables/useBreakpoints"
import { useBuilderOptions } from "@/composables/useBuilderOptions"

const props = defineProps({
  config: {
    type: Object,
    required: false,
  },
  breakpointHandle: {
    type: String,
    required: false,
  },
  modelValue: { type: Object, required: true },
})

const { bp } = useBreakpoints(props.breakpointHandle)

const { getImageSizes } = useBuilderOptions()

const emit = defineEmits(["update:modelValue"])
const { update, filterOutEmptyValues, responsivePlaceholder } =
  useFieldType(emit)

const background: any = reactive({
  image: {
    id: {
      ...(props.modelValue?.image?.id || {}),
    },
    size: {
      ...(props.modelValue?.image?.size || {}),
    },
    position: {
      ...(props.modelValue?.image?.position || {}),
    },
    "image-size": {
      ...(props.modelValue?.image?.["image-size"] || {}),
    },
    "blend-mode": {
      ...(props.modelValue?.image?.["blend-mode"] || {}),
    },
    repeat: {
      ...(props.modelValue?.image?.repeat || {}),
    },
  },
  video_url: props.modelValue?.video_url || null,
  color: {
    ...(props.modelValue?.color || {}),
  },
  separate_element: props.modelValue?.separate_element || false,
  background_element_class: props.modelValue?.background_element_class || null,
})

watch(background, (val: any) => {
  const filtered = filterOutEmptyValues(val)
  update(filtered)
})
</script>

<template>
  <field-group>
    <color-select-field
      class="g-col-12 w-100"
      handle="backgroundColor"
      :placeholder="responsivePlaceholder(background, 'color', bp)"
      :config="{
        label: 'Background Color',
      }"
      v-model="background.color[bp]" />
    <media-field
      class="g-col-12 w-100"
      handle="backgroundImage"
      :placeholder="responsivePlaceholder(background.image, 'id', bp)"
      :config="{
        multiple: false,
        label: 'Background Image',
      }"
      v-model="background.image['id'][bp]" />

    <text-field
      class="g-col-12 flex-grow-1 flex-basis-0"
      handle="background-class"
      :config="{
        label: 'Background video url',
        popover: 'Paste a youtube or vimeo url here for background video',
      }"
      v-model="background.video_url" />
    <div class="g-col-12 d-flex gap-3">
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="size"
        :placeholder="responsivePlaceholder(background.image, 'size', bp)"
        :config="{
          label: 'Size',
          options: [
            { value: 'none', label: 'None' },
            { value: '100', label: '100% auto' },
            { value: 'cover', label: 'Cover' },
            { value: 'contain', label: 'Contain' },
            { value: 'fit', label: 'Fit' },
            { value: 'fill', label: 'Fill' },
            { value: 'scale-down', label: 'Scale Down' },
          ],
        }"
        v-model="background.image['size'][bp]" />
      <select-field
        class="g-col-12 flex-grow-1 flex-basis-0"
        handle="position"
        :placeholder="responsivePlaceholder(background.image, 'position', bp)"
        :config="{
          label: 'Position',
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
        }"
        v-model="background.image['position'][bp]" />
      <select-field
        class="g-col-12 flex-grow-1 flex-basis-0"
        handle="repeat"
        :placeholder="responsivePlaceholder(background.image, 'repeat', bp)"
        :config="{
          label: 'Repeat',
          options: [
            { value: 'repeat', label: 'Repeat' },
            { value: 'repeat-x', label: 'Repeat Horizontally' },
            { value: 'repeat-y', label: 'Repeat Vertically' },
            { value: 'no-repeat', label: 'No Repeat' },
          ],
        }"
        v-model="background.image['repeat'][bp]" />
    </div>

    <select-field
      class="g-col-12 flex-grow-1 flex-basis-0"
      handle="image-size"
      :placeholder="responsivePlaceholder(background.image, 'size', bp)"
      :config="{
        label: 'Wordpress Image Size (crop)',
        options: getImageSizes(),
      }"
      v-model="background.image['image-size'][bp]" /> 

    <select-field
      class="g-col-12 flex-grow-1 flex-basis-0"
      handle="blend-mode"
      :placeholder="responsivePlaceholder(background.image, 'blend-mode', bp)"
      :config="{
        label: 'Blend mode',
        options: [
          'normal',
          'multiply',
          'screen',
          'overlay',
          'darken',
          'lighten',
          'color-dodge',
          'saturation',
          'color',
          'luminosity',
        ],
      }"
      v-model="background.image['blend-mode'][bp]" />
    <toggle-field
      class="g-col-12 flex-grow-1 flex-basis-0"
      handle="separate-element"
      :config="{
        label: 'Separate Element?',
        popover:
          'If enabled, the background will be applied to a separate div element, rather than the parent container.',
      }"
      v-model="background.separate_element" />
    <text-field
      v-if="background?.separate_element"
      class="g-col-12 flex-grow-1 flex-basis-0"
      handle="background-class"
      :config="{
        label: 'Background element class',
        popover:
          'If separate element is enabled, you can add custom classes to it.',
      }"
      v-model="background.background_element_class" />
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
