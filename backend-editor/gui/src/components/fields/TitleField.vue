<script lang="ts" setup>
import { toRefs, ref, watch, reactive } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderOptions } from "@/composables/useBuilderOptions"
import { useBreakpoints } from "../../composables/useBreakpoints"

const { getThemeColours, getFontSize } = useBuilderOptions()
const { bp } = useBreakpoints("global")

const props = defineProps({ ...commonProps })

const { config, modelValue, uuid } = toRefs(props)
const value = ref(modelValue?.value || {})

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const fields: any = reactive({
  text: props.modelValue?.text || "",
  level: props.modelValue?.level || "",
  size: props.modelValue?.size || {},
  weight: props.modelValue?.weight || {},
  color: props.modelValue?.color || {},
  class: props.modelValue?.class || "",
})

const forceDelete = (val: any, resetVal: any = {}) => {
  fields[val] = resetVal
}

watch(fields, (newValue) => {
  update(newValue)
})
</script>

<template>
  <bs-card :label="config.label">
    <template v-slot:body>
      <field-group>
        <div class="d-flex flex-column gap-3 card-body">
          <richtext-field
            class="w-100"
            handle="text"
            :config="{
              ...config,
              label: false,
            }"
            v-model="value['text']" />
          <div class="d-flex gap-4">
            <radio-buttons-field
              class=""
              handle="level"
              :uuid="uuid"
              :config="{
                ...config,
                label: 'Level',
                popover: 'Choose which heading-level tag this module will be.',
                options: ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
              }"
              v-model="fields.level" />
            <select-field
              class="flex-grow-1 flex-basis-0"
              @mouseover.ctrl="forceDelete('size')"
              handle="size"
              :config="{
                label: 'Size',
                options: getFontSize(),
                placeholder: 'Default',
                responsive: true,
                popover:
                  'Choose which class to apply to this heading tag if the font size needs to be different than the level (for SEO purposes).',
                taggable: true,
              }"
              v-model="fields.size[bp]" />
            <select-field
              class="flex-grow-1 flex-basis-0"
              @mouseover.ctrl="forceDelete('weight')"
              handle="weight"
              :config="{
                label: 'Weight',
                options: ['light', 'normal', 'bold'],
                placeholder: 'Default',
                responsive: true,
                popover:
                  'Choose which class to apply to this heading tag if the font size needs to be different than the level (for SEO purposes).',
                taggable: true,
              }"
              v-model="fields.weight[bp]" />
          </div>
          <div class="d-flex gap-3">
            <select-field
              class="flex-grow-1 flex-basis-0"
              @mouseover.ctrl="forceDelete('color')"
              handle="colour"
              :config="{
                label: 'Colour',
                options: getThemeColours(),
                popover: 'Change the colour of this heading tag',
                placeholder: 'Default',
                responsive: true,
                popover: 'Change the colour of this heading tag.',
                taggable: true,
              }"
              v-model="fields.color[bp]" />
            <text-field
              class="flex-grow-1"
              handle="class"
              type="text"
              v-model="fields.class"
              placeholder=""
              :config="{
                label: 'Class',
                popover: 'Add a custom class to the heading tag.',
              }" />
          </div>
        </div>
      </field-group>
    </template>
  </bs-card>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
