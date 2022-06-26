<template lang="">
  <div class="d-flex flex-column gap-3">
    <component
      v-for="field in ModuleType.fields"
      :handle="field.handle"
      :config="field.config || {}"
      :key="field.handle"
      v-model="value[field.handle]"
      :is="field.type" />
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from "vue"
import { useBuilderStore } from "../../stores/builder"
const props = defineProps({
  type: {
    type: String,
    required: true,
  },
  component: {
    type: Object,
    required: true,
  },
})

const { getFieldDefaultsForType } = useBuilderStore()
const value = ref(props.component.value)

const ModuleType = computed((): any => {
  return getFieldDefaultsForType(props.type)
})

console.log({ fields: props.type })
</script>
<style lang=""></style>
