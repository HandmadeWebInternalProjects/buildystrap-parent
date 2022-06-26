<template lang="">
  <component
    v-for="field in fields"
    :handle="field.handle"
    :config="field.config || {}"
    :key="field.handle"
    v-model="value[field.path][field.hanle]"
    :is="field.type" />
</template>

<script setup lang="ts">
import { ref, reactive, watch } from "vue"
const props = defineProps({
  settingsFields: {
    type: Object,
    required: true,
  },
  component: {
    type: Object,
    required: true,
  },
})

const fields = ref(props.settingsFields)
const component = ref(props.component)
const value = reactive({})

watch(value, (newValue) => {
  console.log(newValue)
  Object.assign(component.value, newValue)
})

console.log(value)
</script>
<style lang=""></style>
