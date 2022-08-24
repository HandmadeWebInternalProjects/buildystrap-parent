<script lang="ts" setup>
import { toRefs, ref, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const value = ref(modelValue?.value || {})

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

watch(value.value, (newValue) => {
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
          v-model="value['image']" />
      </div>

      <select-field
        class="flex-grow-1 flex-basis-0"
        handle="size"
        :config="{
          label: 'Image Fit',
          options: ['contain', 'cover', 'fit', 'fill'],
          popover: 'Choose how the image should fit within the container.',
          placeholder: 'Image Fit',
        }"
        v-model="value['object_fit']" />

      <div class="d-flex gap-4">
        <text-field
          class="flex-grow-1"
          :config="{ label: 'Width' }"
          v-model="value['width']" />
        <text-field
          class="flex-grow-1"
          :config="{ label: 'Height' }"
          v-model="value['height']" />
      </div>
      <div class="d-flex gap-4">
        <text-field
          class="flex-grow-1"
          :config="{ label: 'Max Width' }"
          v-model="value['max_width']" />
        <text-field
          class="flex-grow-1"
          :config="{ label: 'Max Height' }"
          v-model="value['max_height']" />
      </div>
    </template>
  </bs-card>
</template>

<style lang=""></style>
