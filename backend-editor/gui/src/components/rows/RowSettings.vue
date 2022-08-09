<template lang="">
  <bs-tabs>
    <bs-tab :active="true" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
    <bs-tab name="columns">
      <column-settings
        class="mb-4"
        v-for="column in component.columns"
        :field="column"
        :key="'row-cols' + column.uuid" />
    </bs-tab>
    <bs-tab name="visibility">
      <visibility-tab-settings v-model="config" />
    </bs-tab>
  </bs-tabs>
</template>

<script setup lang="ts">
import { ref, computed } from "vue"
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
