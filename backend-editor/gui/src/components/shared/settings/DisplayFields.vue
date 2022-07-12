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

const display: any = reactive({
  type: props.modelValue["type"] || {},
})

watch(display, (val: any) => {
  update(filterOutEmptyValues(val))
})
</script>

<template>
  <field-group>
    <select-field
      class="w-100"
      handle="type"
      :placeholder="responsivePlaceholder(display, 'type', bp)"
      :config="{
        label: 'Type',
        options: ['Flex', 'Grid'],
        taggable: true,
      }"
      v-model="display.type[bp]" />

    <div v-if="display.type[bp] === 'Flex'">
      <div class="d-flex gap-4">Flex</div>
    </div>

    <div v-if="display.type[bp] === 'Grid'">
      <div class="d-flex gap-4">Grid</div>
    </div>
  </field-group>
</template>

<style lang="scss">
.flex-basis-0 {
  flex-basis: 0;
}
</style>
