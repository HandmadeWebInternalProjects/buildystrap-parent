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

const entries = ref<Array<{ label: string; value: any }>>([])
const selected = computed({
  get() {
    return modelValue?.value || []
  },
  set(newVal: Array<any> | null) {
    update(newVal)
  },
})

const loading = ref(true)
const endpoint = config.value?.endpoint || "posts"

const depends_on = computed(() => {
  if (!config.value?.depends_on) return null
  let deps = config.value?.depends_on
  if (deps && deps.includes(".")) {
    return deps.split(".")?.reduce((acc: any, curr: any) => {
      if (Array.isArray(acc)) return acc.map((el) => el[curr])
      if (acc?.[curr]) return acc[curr]
      return null
    }, values?.value)
  }
  return values?.value?.[config.value?.depends_on]
})

let data_type = config.value?.data_type || null

const returnValue =
  (config.value?.return_value || config.value?.return_values) ?? "id"
const returnLabel = config.value.return_label || "title.rendered"

const fetchFromEndpoint = async (endpoint: string) => {
  try {  
    const res = await fetch(`${endpoint}?per_page=100`)
    return await res.json()
  } catch (error: any) {
    throw new Error(error)
  }
}

const fetchFromDataType = async () => {
  try {
    const res = await fetch(
      `${getBuilderConfig.rest_endpoint}wp/v2/${data_type}?per_page=100`
    )
    let data = await res.json()
    data = Object.values(data).filter((el: any) => {
      let key = depends_on.value

      if (Array.isArray(key)) {
        return el.types.some((el: string) => key.includes(el))
      }
      return el.types.includes(key)
    })
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

const fetchEntries = async (): Promise<Array<{ [key: string]: any }>> => {
  let data: Array<{ [key: string]: any }>
  try {
    const res = await fetch(
      `${getBuilderConfig.rest_endpoint}${endpoint}?per_page=100`
    )
    data = await res.json()
    return data
  } catch (error: any) {
    throw new Error(error)
  }
}

const mapEntries = async () => {
  loading.value = true
  let mappedEntries: any = null

  if (config.value?.depends_on) {
    if ( config.value?.endpoint ) {
      mappedEntries = await fetchFromEndpoint(endpoint + depends_on.value)
    } else if (depends_on.value) {
      if (data_type === "endpoint") {
        if (Array.isArray(depends_on.value)) {
          mappedEntries = await Promise.all(
            depends_on.value.map((endpoint : string) =>
              fetchFromEndpoint(endpoint)
            )
          )
          mappedEntries = mappedEntries.flat()
        } else if (typeof depends_on.value === "string") {
          mappedEntries = await fetchFromEndpoint(depends_on.value)
        }
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
    const payload: { label: any; value: any } = {
      label: getDeep(entry, returnLabel),
      value: "",
    }

    if (Array.isArray(returnValue)) {
      payload.value = {}
      returnValue.forEach((key: string) => {
        Object.entries(key).forEach(([k, v]) => {
          payload.value[k] = getDeep(entry, v)
        })
      })
    } else {
      payload["value"] = getDeep(entry, returnValue)
    }

    return payload
  })

  loading.value = false
}

watch(depends_on, () => {
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
          options: entries || [],
          label: false,
          multiple: config?.multiple,
          taggable: config?.taggable,
        }"
        @input="update(($event?.target as HTMLInputElement)?.value)"
        :placeholder="config.placeholder || handle" />
    </label>
  </div>
</template>

<style lang=""></style>