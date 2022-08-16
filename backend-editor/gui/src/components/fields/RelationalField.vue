<script lang="ts" setup>
import { toRefs, ref, computed, onMounted } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderStore } from "../../stores/builder"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)
const { getBuilderConfig } = useBuilderStore()

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const entries = ref<Array<{ label: string; value: number }>>([])
const selected = computed({
  get() {
    return modelValue?.value || []
  },
  set(newVal: Array<number>) {
    update(newVal)
  },
})

const loading = ref(true)
const postType = config.value?.post_type || "posts"
const returnValue = config.value.return_value || "id"
const returnLabel = config.value.return_label || "title.rendered"

const fetchEntries = async (): Promise<Array<{ [key: string]: any }>> => {
  let data: Array<{ [key: string]: any }>
  try {
    const res = await fetch(
      `${getBuilderConfig.rest_endpoint}wp/v2/${postType}`
    )
    data = await res.json()
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

onMounted(async () => {
  let mappedEntries = await fetchEntries()

  if (!mappedEntries) return

  mappedEntries = Array.isArray(mappedEntries)
    ? mappedEntries
    : Object.values(mappedEntries)

  entries.value = mappedEntries.map((entry: any) => {
    return {
      value: returnValue
        .split(".")
        .filter((path) => path)
        .reduce((a, b) => a && a[b], entry),
      label: returnLabel
        .split(".")
        .filter((path) => path)
        .reduce((a, b) => a && a[b], entry),
    }
  })

  loading.value = false
})
</script>

<template>
  <div>
    <label class="w-100">
      <field-label
        v-if="config.label !== false"
        :label="config?.label !== undefined ? config.label : handle"
        :popover="config?.popover" />
      <select-field
        class="w-100 loading"
        handle="relational-selector"
        v-model="selected"
        :key="entries"
        :loading="loading"
        :config="{
          options: entries,
          label: false,
          multiple: config?.multiple,
        }"
        @input="update(($event?.target as HTMLInputElement)?.value)"
        :placeholder="config.placeholder || handle" />
    </label>
  </div>
</template>

<style lang=""></style>
