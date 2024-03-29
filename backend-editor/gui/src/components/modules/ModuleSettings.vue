<template>
  <bs-tabs>
    <bs-tab :uuid="`content-${uuid}`" :active="true" name="content">
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
    <bs-tab :uuid="`design-${uuid}`" name="design">
      <design-tab-settings v-model="inline" />
    </bs-tab>
    <bs-tab :uuid="`attributes-${uuid}`" name="attributes">
      <settings-tab-settings v-model="attributes" />
    </bs-tab>
    <bs-tab :uuid="`visibility-${uuid}`" name="visibility">
      <visibility-tab-settings v-model="config" />
    </bs-tab>
  </bs-tabs>
</template>

<script setup lang="ts">
import { computed, ref, onBeforeMount, provide } from "vue"
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
const { getModuleBlueprintForType, builderConfig } = useBuilderStore()
const value = ref(props.component.values)

// provide component to children
provide("component", props.component)

const ModuleType = computed((): any => {
  return getModuleBlueprintForType(props.type)
})

const meta = ref(null)
const { getPageCache, updatePageCache } = useLocalStorage(builderConfig.post_id)

onBeforeMount(() => {
  const pageCache = getPageCache()
  meta.value = pageCache[props.component.uuid] || []
})

const updateMeta = (meta: any) => {
  updatePageCache(props.component.uuid, meta)
}

const component = ref(props.component)
const uuid = component.value.uuid

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
