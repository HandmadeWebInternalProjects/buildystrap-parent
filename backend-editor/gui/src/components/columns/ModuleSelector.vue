<template>
  <div class="h-full bg-white overflow-auto pt-0">
    <ul class="nav nav-pills border-bottom" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button
          class="nav-link active"
          data-bs-toggle="tab"
          data-bs-target="#regular-module-tab"
          type="button"
          role="tab"
          aria-controls="regular-module"
          aria-selected="true">
          Regular Modules
        </button>
      </li>
      <li v-if="!disableGlobals" class="nav-item" role="presentation">
        <button
          @click="openGlobalsTab"
          class="nav-link"
          data-bs-toggle="tab"
          data-bs-target="#global-module-tab"
          type="button"
          role="tab"
          aria-controls="global-module"
          aria-selected="false">
          Global Modules
        </button>
      </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content card mt-4 p-4 rounded">
      <div
        class="tab-pane active"
        id="regular-module-tab"
        role="tabpanel"
        aria-labelledby="regular-module-tab"
        tabindex="0">
        <ul class="m-0 p-0 d-flex flex-column">
          <li
            class="p-1"
            v-for="(field, key) in getModuleBlueprints"
            :key="key">
            <div
              class="border bg-700 text-white cursor-pointer transition-all scale-md-hover w-100 px-3 py-2 d-flex gap-2 align-items-center group rounded shadow-sm"
              @click="addField(field, key)"
              style="
                transform: perspective(1px) translateZ(0);
                backface-visibility: hidden;
              ">
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
      <div
        class="tab-pane"
        id="global-module-tab"
        role="tabpanel"
        aria-labelledby="global-module-tab"
        tabindex="0">
        <span v-if="!disableGlobals && globalsVisible">
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
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue"
import { storeToRefs } from "pinia"
import { createModule } from "../../factories/modules/moduleFactory"
import type { ModuleType } from "../../factories/modules/moduleFactory"
import { useBuilderStore } from "../../stores/builder"

const { setGlobals } = useBuilderStore()
const { getModuleBlueprints, getGlobalModules } = storeToRefs(useBuilderStore())

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
