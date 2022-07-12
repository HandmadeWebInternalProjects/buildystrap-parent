<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { useBreakpoints } from "../../../composables/useBreakpoints"

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
    repeat: {
      ...(props.modelValue?.image?.repeat || {}),
    },
  },
  color: {
    ...(props.modelValue?.color || {}),
  },
})

watch(background, (val: any) => {
  const filtered = filterOutEmptyValues(val)
  update(filtered)
})
</script>

<template>
  <field-group>
    <select-field
      class="w-100"
      handle="backgroundColor"
      :placeholder="responsivePlaceholder(background, 'color', bp)"
      :config="{
        label: 'Background Color',
        options: ['Primary', 'Secondary', 'Tertiary'],
        taggable: true,
      }"
      v-model="background.color[bp]" />
    <media-field
      class="w-100"
      handle="backgroundImage"
      :placeholder="responsivePlaceholder(background.image, 'id', bp)"
      :config="{
        multiple: false,
        label: 'Background Image',
      }"
      v-model="background.image['id'][bp]" />
    <div class="d-flex gap-3">
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="size"
        :placeholder="responsivePlaceholder(background.image, 'size', bp)"
        :config="{
          label: 'Size',
          options: [
            { value: 'cover', label: 'Cover' },
            { value: 'contain', label: 'Contain' },
            { value: 'fit', label: 'Fit' },
            { value: 'fill', label: 'Fill' },
          ],
          taggable: true,
        }"
        v-model="background.image['size'][bp]" />
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="position"
        :placeholder="responsivePlaceholder(background.image, 'position', bp)"
        :config="{
          label: 'Position',
          options: [
            { value: 'left', label: 'Left' },
            { value: 'left top', label: 'Left Top' },
            { value: 'left bottom', label: 'Left Bottom' },
            { value: 'right', label: 'Right' },
            { value: 'right top', label: 'Right Top' },
            { value: 'right bottom', label: 'Right Bottom' },
            { value: 'center', label: 'Center' },
            { value: 'center top', label: 'Center Top' },
            { value: 'center bottom', label: 'Center Bottom' },
          ],
          taggable: true,
        }"
        v-model="background.image['position'][bp]" />
      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="repeat"
        :placeholder="responsivePlaceholder(background.image, 'repeat', bp)"
        :config="{
          label: 'Repeat',
          options: [
            { value: 'repeat', label: 'Repeat' },
            { value: 'no-repeat', label: 'No Repeat' },
          ],
          taggable: true,
        }"
        v-model="background.image['repeat'][bp]" />
    </div>
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
