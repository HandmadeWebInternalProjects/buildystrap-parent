<template lang="">
  <bs-tabs>
    <bs-tab :active="true" name="Options">
      <toggle-field
        handle="boxed_layout"
        :config="{ label: 'Boxed Layout', options: ['true', 'false'] }"
        v-model="config['boxed_layout']" />
    </bs-tab>
    <bs-tab name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
  </bs-tabs>
  <div class="d-flex flex-column gap-3">
    <!-- <dynamic-settings :settings-fields="fields" :component="component" />-->
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

const config = reactive(props?.component?.config || {})
const inline = ref(props.component.value?.inline || {})
const attributes = ref(props.component.value?.attributes || {})
</script>
<style lang=""></style>
