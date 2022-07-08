<script lang="ts" setup>
import { reactive, watch } from "vue"
import { useFieldType } from "./useFieldType"
import { useBreakpoints } from "../../composables/useBreakpoints"
const { bp } = useBreakpoints("background")

const props = defineProps({
  config: {
    type: Object,
    required: false,
  },
  modelValue: { type: Object, required: true },
})

const emit = defineEmits(["update:modelValue"])
const { update, filterOutEmptyValues, responsivePlaceholder } =
  useFieldType(emit)

const background: any = reactive({
  image: {
    size: {
      ...(props.modelValue?.image?.size || {}),
    },
    position: {
      ...(props.modelValue?.image?.position || {}),
    },
  },
  color: {
    ...(props.modelValue?.color || {}),
  },
})

watch(background, (val: any) => {
  const filtered = filterOutEmptyValues(val)
  console.log({ filtered })
  update(filtered)
})
</script>

<template>
  <div class="card border-0 bg-100">
    <div class="card-header pb-1 border-0 d-flex align-items-center">
      <field-label :label="config?.label || ''" />
      <breakpoint-switcher-field handle="background" class="ms-auto" />
    </div>

    <div class="card-body">
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
          :config="{
            multiple: false,
            label: 'Background Image',
          }"
          v-model="background.image['image']" />
        <div class="d-flex gap-4">
          <select-field
            class="flex-grow-1 flex-basis-0"
            handle="size"
            :placeholder="responsivePlaceholder(background.image, 'size', bp)"
            :config="{
              label: 'Size',
              options: ['cover', 'contain', 'fit', 'fill'],
              placeholder: 'Background.image Size',
              taggable: true,
            }"
            v-model="background.image['size'][bp]" />
          <select-field
            class="flex-grow-1 flex-basis-0"
            handle="position"
            :placeholder="
              responsivePlaceholder(background.image, 'position', bp)
            "
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
              placeholder: 'Background Position',
              taggable: true,
            }"
            v-model="background.image['position'][bp]" />
        </div>
      </field-group>
    </div>
  </div>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
