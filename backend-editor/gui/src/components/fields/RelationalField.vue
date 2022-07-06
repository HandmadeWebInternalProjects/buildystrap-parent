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

const postType = config.value.post_type || "posts"

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

  entries.value = mappedEntries.map((entry: any) => {
    return {
      value: entry.id,
      label: entry.title.rendered,
    }
  })

  loading.value = false
})
</script>

<template>
  <div>
    <label class="w-100">
      <field-label :label="config.label || handle" />
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
