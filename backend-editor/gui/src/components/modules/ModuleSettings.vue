<template lang="">
  <field-group>
    <component
      v-for="(field, key) in ModuleType.fields"
      :handle="key"
      :type="field.type"
      :module-type="props.type"
      :config="field.config || {}"
      :key="key"
      :meta="meta"
      v-model="value[key]"
      :is="field.type"
      @update-meta="updateMeta" />
  </field-group>
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
const { getModuleBlueprintForType, config } = useBuilderStore()
const value = ref(props.component.values)

const ModuleType = computed((): any => {
  return getModuleBlueprintForType(props.type)
})

const meta = ref(null)
const { getPageCache, updatePageCache } = useLocalStorage(config.post_id)

onBeforeMount(() => {
  const pageCache = getPageCache()
  console.log({ pageCache })
  meta.value = pageCache[props.component.uuid] || []
})

const updateMeta = (meta: any) => {
  updatePageCache(props.component.uuid, meta)
}
</script>
<style lang=""></style>
