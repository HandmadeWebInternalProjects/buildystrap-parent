import { defineStore } from "pinia"

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

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    config: <BuildyConfig>{},
    content: [] as any[],
    pasteLocations: <string[]>[],
    registeredComponents: {},
  }),
  getters: {
    getBuilderContent: (state) => state.content,
    getRegisteredComponents: (state): { [key: string]: any } => {
      return state.registeredComponents
    },
    getModuleBlueprintForType: (state) => (type: string) => {
      return state.config.moduleBlueprints[type]
    },
    getModuleBlueprints: (state): { [key: string]: any } =>
      state.config.moduleBlueprints,
    getModuleStyles: (state) => state.config?.moduleStyles,
    getGlobalSections: (state) => state.config?.globalSections ?? [],
    getLibrarySections: (state) => state.config?.librarySections ?? [],
    getGlobalModules: (state): { [key: string]: any } =>
      state.config?.globalModules ?? [],
    getBuilderConfig: (state) => state.config,
    getBuilderOptions: (state) => state.config.builder_options,
    getPasteLocations: (state) => state.pasteLocations,
  },
  actions: {
    setBuilderContent(payload: any) {
      //replace this.content array with payload in a reactive way
      this.content = [...payload]
    },
    sortBlueprintsAlpha() {
      this.config.moduleBlueprints = Object.keys(this.config.moduleBlueprints)
        .sort()
        .reduce(
          (acc, key) => ({
            ...acc,
            [key]: this.config.moduleBlueprints[key],
          }),
          {}
        )
    },
    setConfig(config: BuildyConfig) {
      this.config = { ...config }
      if (this.config?.moduleBlueprints) {
        this.sortBlueprintsAlpha()
      }
    },
    setGlobals(globals: { [key: string]: any }, type: string) {
      this.config.globalModules[type] = Object.assign({}, { ...globals })
    },
    setRegisteredComponents(payload: { [key: string]: any }) {
      this.registeredComponents = { ...payload }
    },
    updatePasteLocations(payload: string[]) {
      this.pasteLocations = payload
    },
  },
})
