<script lang="ts" setup>
import { toRefs, ref, computed, onMounted, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderStore } from "../../stores/builder"
import { getDeep } from "@/utils/objects"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue, values } = toRefs(props)
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
const endpoint = config.value?.endpoint || "posts"
const depends_on = config.value?.depends_on
  ? computed(() => values.value[config.value?.depends_on])
  : ref(null)
let data_type = config.value?.data_type || null
const returnValue = config.value.return_value || "id"
const returnLabel = config.value.return_label || "title.rendered"

const fetchFromEndpoint = async (endpoint) => {
  try {
    const res = await fetch(endpoint)
    let data = await res.json()
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

const fetchFromDataType = async () => {
  try {
    const res = await fetch(
      `${getBuilderConfig.rest_endpoint}wp/v2/${data_type}`
    )
    let data = await res.json()
    data = Object.values(data).filter((el) => {
      return el.types.includes(depends_on.value)
    })
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

const fetchEntries = async (): Promise<Array<{ [key: string]: any }>> => {
  let data: Array<{ [key: string]: any }>
  try {
    console.log("fired from main")
    const res = await fetch(`${getBuilderConfig.rest_endpoint}${endpoint}`)
    data = await res.json()
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

const mapEntries = async () => {
  loading.value = true
  let mappedEntries

  if (config.value?.depends_on) {
    if (depends_on.value) {
      if (data_type === "endpoint") {
        mappedEntries = await fetchFromEndpoint(depends_on.value)
      } else {
        mappedEntries = await fetchFromDataType()
      }
    }
  } else {
    mappedEntries = await fetchEntries()
  }

  if (!mappedEntries) {
    loading.value = false
    entries.value = []
    selected.value = null
    return
  }

  mappedEntries = Array.isArray(mappedEntries)
    ? mappedEntries
    : Object.values(mappedEntries)

  entries.value = mappedEntries.map((entry: any) => {
    return {
      value: getDeep(entry, returnValue),
      label: returnLabel
        .split(".")
        .filter((path) => path)
        .reduce((a, b) => a && a[b], entry),
    }
  })

  loading.value = false
}

watch(depends_on, (newVal) => {
  mapEntries()
})

onMounted(async () => {
  mapEntries()
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
