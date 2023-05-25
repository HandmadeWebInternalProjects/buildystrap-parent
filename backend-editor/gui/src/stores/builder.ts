import { defineStore } from "pinia"
import { ref, computed } from "vue"

export type BuildyConfig = {
  site_url: string
  theme_url: string
  rest_endpoint: string
  moduleBlueprints: { [key: string]: any }
  post_type: string
  post_id: number
  is_admin: boolean
  is_global_module: boolean
  builder_options: { [key: string]: any }
  moduleStyles: { [key: string]: any }
  globalSections: { [key: string]: any }
  librarySections: { [key: string]: any }
  globalModules: { [key: string]: any }
}

export const useBuilderStore = defineStore("builder", () => {
  const builderConfig = ref<BuildyConfig>({
    site_url: "",
    theme_url: "",
    rest_endpoint: "",
    moduleBlueprints: {},
    post_type: "",
    post_id: 0,
    is_admin: false,
    is_global_module: false,
    builder_options: {},
    moduleStyles: {},
    globalSections: {},
    librarySections: {},
    globalModules: {},
  })
  const builderContent = ref<any[]>([])
  const pasteLocations = ref<string[]>([])
  const registeredComponents = ref<{ [key: string]: any }>({})

  const isGlobalModule = computed(() => builderConfig?.value?.is_global_module)

  const getModuleBlueprintForType = computed(
    () => (type: string) => builderConfig?.value?.moduleBlueprints[type]
  )
  const getModuleBlueprints = computed(
    () => builderConfig?.value?.moduleBlueprints
  )
  const getModuleStyles = computed(() => builderConfig?.value?.moduleStyles)
  const getGlobalSections = computed(
    () => builderConfig?.value?.globalSections ?? []
  )
  const getLibrarySections = computed(
    () => builderConfig?.value?.librarySections ?? []
  )
  const getGlobalModules = computed(
    () => builderConfig?.value?.globalModules ?? []
  )
  const getBuilderOptions = computed(
    () => builderConfig?.value?.builder_options
  )

  function setBuilderContent(payload: any) {
    console.log("setBuilderContent", payload)
    //replace this.content array with payload in a reactive way
    builderContent.value = [...payload]
  }

  function sortBlueprintsAlpha() {
    builderConfig.value.moduleBlueprints = Object.keys(
      builderConfig.value.moduleBlueprints
    )
      .sort()
      .reduce(
        (acc, key) => ({
          ...acc,
          [key]: builderConfig.value.moduleBlueprints[key],
        }),
        {}
      )
  }
  function setConfig(config: BuildyConfig) {
    builderConfig.value = { ...config }
    if (builderConfig.value?.moduleBlueprints) {
      sortBlueprintsAlpha()
    }
  }
  function setGlobals(globals: { [key: string]: any }, type: string) {
    builderConfig.value.globalModules[type] = Object.assign({}, { ...globals })
  }
  function setRegisteredComponents(payload: { [key: string]: any }) {
    registeredComponents.value = { ...payload }
  }
  function updatePasteLocations(payload: string[]) {
    pasteLocations.value = payload
  }

  return {
    builderConfig,
    builderContent,
    pasteLocations,
    registeredComponents,
    isGlobalModule,
    getModuleBlueprintForType,
    getModuleBlueprints,
    getModuleStyles,
    getGlobalSections,
    getLibrarySections,
    getGlobalModules,
    getBuilderOptions,
    setBuilderContent,
    setConfig,
    setGlobals,
    setRegisteredComponents,
    updatePasteLocations,
  }
})
