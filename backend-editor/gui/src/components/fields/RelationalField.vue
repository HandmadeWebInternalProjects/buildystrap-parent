<script lang="ts" setup>
import { toRefs, ref, computed, onMounted } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderStore } from "../../stores/builder"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)
const { getConfig } = useBuilderStore()

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const entries = ref<Array<{ label: string; value: number }>>([])
const selected = computed({
  get() {
    return modelValue?.value || []
  },
  set(newVal: Array<number>) {
    console.log({ newVal })

    update(newVal)
  },
})

const fetchEntries = async (): Promise<Array<{ [key: string]: any }>> => {
  let data: Array<{ [key: string]: any }>
  try {
    const res = await fetch(
      `${getConfig.rest_endpoint}wp/v2/${config.value.post_type}`
    )
    data = await res.json()
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

onMounted(async () => {
  if (config.value?.post_type) {
    let mappedEntries = await fetchEntries()

    entries.value = mappedEntries.map((entry: any) => {
      return {
        value: entry.id,
        label: entry.title.rendered,
      }
    })
  }
})
</script>

<template>
  <div>
    <label class="w-100">
      <field-label :label="config.label || handle" />
      <select-field
        v-if="entries.length"
        class="w-100"
        handle="relational-selector"
        v-model="selected"
        :key="entries"
        :config="{
          options: entries,
          label: `Choose from ${config?.post_type}`,
          multiple: config?.multiple,
        }"
        @input="update(($event?.target as HTMLInputElement)?.value)"
        :placeholder="config.placeholder || handle" />
    </label>
  </div>
</template>

<style lang=""></style>
