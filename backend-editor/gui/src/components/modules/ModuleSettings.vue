<template lang="">
  <bs-tabs>
    <bs-tab :active="true" name="content">
      <field-group>
        <field-base
          v-for="(field, key) in ModuleType.fields"
          :handle="key"
          :field="field"
          :module-type="props.type"
          :config="field.config || {}"
          :key="key"
          :meta="meta"
          :uuid="component.uuid"
          v-model="value"
          @update-meta="updateMeta" />
      </field-group>
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
</template>

<script setup lang="ts">
import { computed, ref, onBeforeMount } from "vue"
import { useBuilderStore } from "../../stores/builder"
import { useLocalStorage } from "../../composables/useLocalStorage"

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
const { getModuleBlueprintForType, getBuilderConfig } = useBuilderStore()
const value = ref(props.component.values)

console.log({ value })

const ModuleType = computed((): any => {
  return getModuleBlueprintForType(props.type)
})

const meta = ref(null)
const { getPageCache, updatePageCache } = useLocalStorage(
  getBuilderConfig.post_id
)

onBeforeMount(() => {
  const pageCache = getPageCache()
  meta.value = pageCache[props.component.uuid] || []
})

const updateMeta = (meta: any) => {
  updatePageCache(props.component.uuid, meta)
}

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
