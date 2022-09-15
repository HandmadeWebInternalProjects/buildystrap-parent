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
    <bs-tab name="visibility">
      <visibility-tab-settings v-model="config" />
    </bs-tab>
  </bs-tabs>
  <div class="d-flex flex-column gap-3">
    <!-- <dynamic-settings :settings-fields="fields" :component="component" />-->
  </div>
</template>

<script setup lang="ts">
import { ref, computed, provide } from "vue"
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

// Module styles injection
provide("component", component.value)

const inline = computed({
  get() {
    return component.value?.inline || {}
  },
  set(value) {
    component.value.inline = value
  },
})

const attributes = computed({
  get() {
    return component.value?.attributes || {}
  },
  set(value) {
    component.value.attributes = value
  },
})

const config = computed({
  get() {
    return component.value?.config || {}
  },
  set(value) {
    component.value.config = value
  },
})
</script>
<style lang=""></style>
