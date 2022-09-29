<script lang="ts" setup>
import { toRefs, computed, onMounted, onUnmounted } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const link = computed({
  get() {
    return modelValue?.value || {}
  },
  set(value) {
    update(value)
  },
})

onMounted(() => {

})

onUnmounted(() => {

})
</script>

<template>
  <div>
    <text-field handle="link-title" v-model="link.title" />
    <relational-field
      class="w-100"
      handle="link-href"
      :placeholder="config.value?.placeholder"
      :config="{
        label: 'Text Colour',
        endpoint: entries || [],
        taggable: true,
      }"
      v-model="link.href" />
    <toggle-field
      class="flex-grow-1 flex-basis-0"
      handle="link-target"
      :config="{
        label: 'Open in new window?',
        popover:
          'If enabled, the background will be applied to a separate div element, rather than the parent container.',
      }"
      v-model="link.target" />
  </div>
</template>

<style lang="scss"></style>
