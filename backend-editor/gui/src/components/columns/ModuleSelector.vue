<template>
  <div class="h-full bg-white overflow-auto pt-0">
    <ul class="nav nav-pills border-bottom" id="myTab" role="tablist">
      <li
        v-for="(tab, i) in tabs"
        :key="`module-tab-${tab.name}`"
        class="nav-item"
        role="presentation">
        <button
          class="nav-link"
          :class="{ active: i === 0 }"
          data-bs-toggle="tab"
          :data-bs-target="`#${tab.name}-tab`"
          type="button"
          role="tab"
          :aria-controls="tab.name"
          aria-selected="true">
          {{ tab.title }}
        </button>
      </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content card mt-4 p-4 rounded">
      <div
        v-for="(tab, i) in tabs"
        :key="`module-tab-${tab.name}`"
        class="tab-pane"
        :class="{ active: i === 0 }"
        :id="`${tab.name}-tab`"
        role="tabpanel"
        :aria-labelledby="`${tab.name}-tab`"
        tabindex="0">
        <ul v-if="tab?.conditions || true" class="m-0 p-0 d-flex flex-column">
          <li
            class="p-1"
            v-for="(moduleItem, key) in tab.modules"
            :key="moduleItem?.title || key">
            <module-selection-pill
              @click="tab?.callback(moduleItem, key)"
              :module-item="moduleItem"
              :handle="key" />
          </li>
        </ul>
      </div>
      <!-- <div
        class="tab-pane"
        id="global-module-tab"
        role="tabpanel"
        aria-labelledby="global-module-tab"
        tabindex="0">
        <span v-if="">
          <ul class="m-0 p-0 d-flex flex-column">
            <li class="p-1" v-for="field in getGlobalModules" :key="field.id">
              <div
                class="border bg-600 text-white cursor-pointer transition-all scale-md-hover w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm"
                @click="addGlobalModule(field)"
                style="
                  transform: perspective(1px) translateZ(0);
                  backface-visibility: hidden;
                ">
                <span class="block pl-2">
                  {{ field.title }}
                </span>
              </div>
            </li>
          </ul>
        </span>
      </div> -->
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue"
import { storeToRefs } from "pinia"
import { createModule } from "../../factories/modules/moduleFactory"
import type { ModuleType } from "../../factories/modules/moduleFactory"
import { useBuilderStore } from "../../stores/builder"

const { setGlobals } = useBuilderStore()
const { getModuleBlueprints, getGlobalModules } = storeToRefs(useBuilderStore())

const regularModules = computed(() => {
  return Object.entries(getModuleBlueprints.value).reduce(
    (acc: any, [key, value]) => {
      if (value?.config?.selectorTab === "regular") {
        acc[key] = value
      }
      return acc
    },
    {}
  )
})

const customModules = computed(() => {
  return Object.entries(getModuleBlueprints.value).reduce(
    (acc: any, [key, value]) => {
      if (
        value?.config?.selectorTab !== "regular" ||
        !value?.config?.selectorTab
      ) {
        acc[key] = value
      }
      return acc
    },
    {}
  )
})

const tabs = [
  {
    name: "regular-module",
    title: "Regular Modules",
    modules: regularModules.value,
    callback: (field: any, key: string | number) => {
      addField(field, key)
    },
  },
  {
    name: "custom-module",
    title: "Custom Modules",
    callback: (field: any, key: string | number) => {
      addField(field, key)
    },
    modules: customModules.value,
  },
  {
    name: "global-module",
    title: "Global Modules",
    conditions: "!disableGlobals && globalsVisible",
    callback: (field: any, key?: string | number) => {
      addGlobalModule(field)
    },
    modules: getGlobalModules.value,
  },
]

const props = defineProps({
  parentArray: {
    type: Array,
    required: true,
  },
  disableGlobals: {
    type: Boolean,
    default: false,
  },
  index: Number,
})

const parentArray = ref(props.parentArray)
const index = ref(props.index)

const openGlobalsTab = async (): Promise<void> => {
  globalsVisible.value = true

  // If we already have them, don't fetch them again
  if (Object.keys(getGlobalModules.value).length) return

  const res = await fetch(
    "http://blank.local/wp-json/buildy/v1/globals?type=module"
  )

  const { data } = await res.json()

  setGlobals(data, "modules")
}

const globalsVisible = ref(false)

const addField = (field: ModuleType, key?: string | number) => {
  field = JSON.parse(JSON.stringify(field))

  const MODULE = "Module"
  const VALUE = {}
  const CONFIG = field.config ?? {}
  const META = field.meta ?? {}
  const TYPE = field.type || key
  const NEW_FIELD = createModule(MODULE, {
    CONFIG,
    TYPE,
    META,
    VALUE,
  })

  parentArray.value.splice(
    index.value !== undefined && index.value !== null
      ? index.value + 1
      : parentArray.value.length,
    0,
    NEW_FIELD
  )
}

const addGlobalModule = (field: { [key: string]: any }) => {
  field = JSON.parse(JSON.stringify(field))

  const GLOBAL_ID = field.id
  const TITLE = field.title

  console.log({ field })

  const NEW_FIELD = createModule("GlobalModule", {
    GLOBAL_ID,
    TITLE,
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
