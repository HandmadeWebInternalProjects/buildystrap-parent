<template lang="">
  <div class="d-flex flex-column gap-3">
    <!-- <dynamic-settings :settings-fields="fields" :component="component" />-->
    <text-field handle="title" v-model="value['title']" />
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from "vue"
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
const attributes = reactive(component?.value.attributes || {})
</script>
<style lang=""></style>
