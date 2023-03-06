<template lang="">
  <bs-tabs>
    <bs-tab :active="true" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
    <bs-tab name="columns">
      <div
        class="grid gap-3"
        :style="`--bs-columns: ${component?.config?.columnCount || 12}`">
        <text-field
          :field="{
            type: 'text-field',
          }"
          class="g-col-12"
          :config="{ label: 'Column count', responsive: true }"
          handle="columns"
          v-model="columnCount[bp]" />
        <column-settings
          v-for="(column, index) in component.columns"
          :field="column"
          :component="column"
          :index="index"
          :key="'row-cols' + column.uuid" />
      </div>
    </bs-tab>
    <bs-tab name="visibility">
      <visibility-tab-settings v-model="config" />
    </bs-tab>
  </bs-tabs>
</template>

<script setup lang="ts">
import { ref, reactive, computed, provide } from "vue"
import { useBreakpoints } from "../../composables/useBreakpoints"
const { bp } = useBreakpoints("global")

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

const columnCount = computed({
  get() {
    // Check if config.value.columnCount exists and is of type object else make it an object
    if (
      component.value.config.columnCount &&
      typeof component.value.config.columnCount !== "object"
    ) {
      component.value.config.columnCount = reactive({ md: 12 })
    }

    return component.value.config.columnCount || {}
  },
  set(value) {
    component.value.config.columnCount = value
  },
})
</script>
<style lang=""></style>
