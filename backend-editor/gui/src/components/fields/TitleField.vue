<script lang="ts" setup>
import { toRefs, ref, watch, reactive } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderOptions } from "@/composables/useBuilderOptions"
import { useBreakpoints } from "../../composables/useBreakpoints"

const { getFontSize } = useBuilderOptions()
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
        <div class="g-col-12 d-flex flex-column gap-3">
          <richtext-field
            class="w-100"
            handle="text"
            :config="{
              ...config,
              label : false,
            }"
            v-model="fields.text" />
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
                  'Change the font-size of the header tag. This will override the default font-size set in the theme.',
                taggable: true,
              }"
              v-model="fields.size[bp]" />
            <select-field
              class="flex-grow-1 flex-basis-0"
              @mouseover.ctrl="forceDelete('weight')"
              handle="weight"
              :config="{
                label: 'Weight',
                options: [
                  '100',
                  '200',
                  '300',
                  'normal',
                  '500',
                  '600',
                  'bold',
                  '800',
                  '900',
                ],
                placeholder: 'Default',
                responsive: true,
                popover: 'Change the font weight of the header tag',
              }"
              v-model="fields.weight[bp]" />
          </div>
          <div class="d-flex gap-3">
            <color-select-field
              class="flex-grow-1 flex-basis-0"
              @mouseover.ctrl="forceDelete('color')"
              handle="colour"
              :config="{
                label: 'Colour',
                popover: 'Change the colour of this heading tag',
                placeholder: 'Default',
                responsive: true,
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
                label: 'Heading Class',
                popover:
                  'Add a custom class, this will apply directly to the H-tag.',
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
