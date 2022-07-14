<script lang="ts" setup>
import { toRefs, ref, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { config, modelValue, uuid } = toRefs(props)
const value = ref(modelValue?.value || {})

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

watch(value.value, (newValue) => {
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
              v-model="value['level']" />
            <select-field
              class="flex-grow-1 flex-basis-0"
              handle="size"
              :config="{
                label: 'Size',
                options: ['h1', 'h2'],
                placeholder: 'Default',
                popover:
                  'Choose which class to apply to this heading tag if the font size needs to be different than the level (for SEO purposes).',
                taggable: true,
              }"
              v-model="value['size']" />
            <select-field
              class="flex-grow-1 flex-basis-0"
              handle="colour"
              :config="{
                label: 'Colour',
                options: ['Primary', 'Secondary'],
                popover: 'Change the colour of this heading tag',
                placeholder: 'Default',
                popover: 'Change the colour of this heading tag.',
                taggable: true,
              }"
              v-model="value['color']" />
          </div>
          <text-field
            class=""
            handle="class"
            type="text"
            :value="value['class']"
            placeholder=""
            :config="{
              label: 'Class',
              popover: 'Add a custom class to the heading tag.',
            }" />
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
