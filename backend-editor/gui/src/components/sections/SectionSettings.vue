<template lang="">
  <div class="d-flex flex-column gap-3">
    <!-- <dynamic-settings :settings-fields="fields" :component="component" />-->
    <toggle-fieldtype
      handle="boxed_layout"
      :config="{ display: 'Boxed Layout', options: ['true', 'false'] }"
      v-model="config['boxed_layout']" />
  </div>
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
const config = reactive(component?.value.config || {})
const attributes = reactive(component?.value.attributes || {})

watch(config, (newValue) => {
  console.log(newValue)
})
</script>
<style lang=""></style>
