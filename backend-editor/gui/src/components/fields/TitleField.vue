<script lang="ts" setup>
import { toRefs, ref, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue, uuid } = toRefs(props)
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
                popover: 'Choose which heading tag this module will use',
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
                  'Choose which class to apply to the heading if the size needs to be different than the tag (for SEO purposes)',
                taggable: true,
              }"
              v-model="value['size']" />
            <select-field
              class="flex-grow-1 flex-basis-0"
              handle="colour"
              :config="{
                label: 'Colour',
                options: ['Primary', 'Secondary'],
                popover: 'Change the colour of the heading tag',
                placeholder: 'Default',
                popover: 'Add a custom class to the heading tag.',
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
            :config="{ label: 'Class' }" />
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
