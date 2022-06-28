<template lang="">
  <div class="d-flex gap-3 flex-column p-4 bg-300">
    <component
      v-for="(field, key) in fields"
      :key="key"
      :handle="key"
      :type="field.type"
      :config="field.config || {}"
      v-model="value[key]"
      :uuid="value._uuid"
      :is="field.type" />
  </div>
</template>
<script lang="ts" setup>
import { ref, watch } from "vue"
const props = defineProps({
  value: {
    type: Object,
    required: true,
  },
  fields: {
    type: Object,
    required: true,
  },
})
const fields = ref(props.fields)
const value = ref(props.value)

const emit = defineEmits(["input"])

watch(value, (newValue) => {
  emit("input", newValue)
})

console.log({ fields })
</script>
<style lang=""></style>
