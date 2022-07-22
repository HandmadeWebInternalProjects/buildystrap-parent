<template>
  <div class="d-flex flex-column gap-4">
    <bs-card
      label="Hide On"
      popover="Select which devices you would like this to be hidden on">
      <template v-slot:body>
        <checkboxes-field
          handle="class"
          :placeholder="responsivePlaceholder(modelValue, 'visibility', bp)"
          :config="{
            options: [
              {
                label: 'Everything - Do not output this module at all',
                value: 'all',
              },
              {
                label: 'Small Devices (most phones, smaller tablets)',
                value: 'xs',
              },
              {
                label: 'Medium Devices (most tablets, smaller laptops)',
                value: 'md',
              },
              {
                label: 'Large Devices (most laptops / desktops)',
                value: 'lg',
              },
              {
                label: 'Extra Large (wide screens, tvs)',
                value: 'xl',
              },
            ],
            label: false,
          }"
          v-model="visibility" />
      </template>
    </bs-card>
  </div>
</template>
<script setup lang="ts">
import { computed, reactive, watch } from "vue"
import { useFieldType } from "../fields/useFieldType"
import { useBreakpoints } from "../../composables/useBreakpoints"
const { bp } = useBreakpoints("global")

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})
const emit = defineEmits(["update:modelValue"])
const { update, filterOutEmptyValues, responsivePlaceholder } =
  useFieldType(emit)

const config = computed({
  get() {
    return props.modelValue || {}
  },
  set(val: any) {
    update(filterOutEmptyValues(val))
  },
})

const visibility = reactive({
  ...(config?.value?.visibility || {}),
})

watch(visibility, (newValue) => {
  console.log({ newValue })

  config.value.visibility = newValue
})
</script>
<style lang=""></style>
