<script lang="ts" setup>
import { computed, reactive, watch } from "vue"
import { useFieldType } from "./useFieldType"
import { useBreakpoints } from "../../composables/useBreakpoints"
const { breakpoint } = useBreakpoints()

const props = defineProps({
  config: {
    type: Object,
    required: false,
  },
  modelValue: { type: Object, required: true },
})

const emit = defineEmits(["update:modelValue"])
const { update, filterOutEmptyValues } = useFieldType(emit)

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
    <div class="card-header pb-1 border-0">
      <field-label :label="config?.label || ''" />
    </div>

    <div class="card-body">
      <ul class="nav nav-pills border-0 mt-1" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link active"
            data-bs-toggle="tab"
            data-bs-target="#background_image_options"
            type="button"
            role="tab"
            aria-controls="regular-module"
            aria-selected="true">
            Image
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#background_color_options"
            type="button"
            role="tab"
            aria-controls="global-module"
            aria-selected="false">
            Color
          </button>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content card rounded">
        <div
          class="tab-pane active"
          id="background_image_options"
          role="tabpanel"
          aria-labelledby="background_image_options"
          tabindex="0">
          <field-group>
            <div class="d-flex flex-column gap-3 card-body">
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
                  :config="{
                    label: 'Size',
                    options: ['cover', 'contain', 'fit', 'fill'],
                    placeholder: 'Background Size',
                    taggable: true,
                  }"
                  v-model="background.image['size'][breakpoint]" />
                <select-field
                  class="flex-grow-1 flex-basis-0"
                  handle="position"
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
                  v-model="background.image['position'][breakpoint]" />
              </div>
            </div>
          </field-group>
        </div>
        <div
          class="tab-pane"
          id="background_color_options"
          role="tabpanel"
          aria-labelledby="background_color_options"
          tabindex="0">
          <field-group>
            <div class="d-flex flex-column gap-3 card-body">
              <select-field
                class="w-100"
                handle="backgroundColor"
                :config="{
                  label: 'Background Color',
                  options: ['Primary', 'Secondary', 'Tertiary'],
                  taggable: true,
                }"
                v-model="background.color[breakpoint]" />
            </div>
          </field-group>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
