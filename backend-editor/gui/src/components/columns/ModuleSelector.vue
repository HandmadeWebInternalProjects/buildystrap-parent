<template>
  <div class="h-full bg-white overflow-auto pt-0">
    <ul class="m-0 p-0 d-flex flex-column">
      <li class="p-1" v-for="(field, key) in getFieldDefaults" :key="key">
        <div
          class="border bg-700 text-white cursor-pointer w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm"
          @click="addField(field, key)">
          <font-awesome-icon
            :icon="field?.icon"
            width="15"
            height="15"
            fill="currentColor"
            aria-controls="offcanvasRight"
            class="flex cursor-pointer pulse"></font-awesome-icon>
          <span class="block pl-2">
            {{ key }}
          </span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue"
import { createModule } from "../../factories/modules/moduleFactory"
import type { ModuleType } from "../../factories/modules/moduleFactory"
import { useBuilderStore } from "../../stores/builder"

const { getFieldDefaults } = useBuilderStore()

console.log(getFieldDefaults)

const props = defineProps({
  parentArray: {
    type: Array,
    required: true,
  },
  index: Number,
})

const parentArray = ref(props.parentArray)
const index = ref(props.index)

const addField = (field: ModuleType, key?: string) => {
  field = JSON.parse(JSON.stringify(field))

  const MODULE = "Module"
  const VALUE = {}
  const CONFIG = field.config ?? {}
  const META = field.meta ?? {}
  const HANDLE = field.handle || key
  const TYPE = field.type || key
  const NEW_FIELD = createModule(MODULE, {
    CONFIG,
    TYPE,
    META,
    VALUE,
    HANDLE,
  })

  parentArray.value.splice(
    index.value !== undefined && index.value !== null
      ? index.value + 1
      : parentArray.value.length,
    0,
    NEW_FIELD
  )
}
</script>

<style></style>
