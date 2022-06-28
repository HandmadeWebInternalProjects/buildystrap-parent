<template lang="">
  <div class="d-flex flex-column gap-3">
    <component
      v-for="(field, key) in ModuleType.fields"
      :handle="key"
      :type="field.type"
      :module-type="props.type"
      :config="field.config || {}"
      :key="key"
      v-model="value[key]"
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
const value = ref(props.component.values)

const ModuleType = computed((): any => {
  return getFieldDefaultsForType(props.type)
})
</script>
<style lang=""></style>
