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
          options: ['cover', 'contain', 'fit', 'fill'],
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
            'left',
            'left top',
            'left bottom',
            'right',
            'right top',
            'right bottom',
            'center',
            'center top',
            'center bottom',
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
          options: ['repeat', 'no-repeat'],
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
