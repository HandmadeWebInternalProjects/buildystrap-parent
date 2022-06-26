<template lang="">
  <!-- <dynamic-settings :settings-fields="fields" :component="component" />-->
  <text-fieldtype handle="title" v-model="value['title']" />
  <text-fieldtype handle="title" v-model="value['title']" />
</template>

<script setup lang="ts">
import { ref, reactive, watch } from "vue"
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

const component = ref(props.component)
const value = reactive(component?.value.value || {})
const attribuets = reactive(component?.value.attributes || {})
</script>
<style lang=""></style>
