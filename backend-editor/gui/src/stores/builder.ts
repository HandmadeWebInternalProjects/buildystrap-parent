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
  globalSections: { [key: string]: any }
  globalModules: { [key: string]: any }
}

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    config: <BuildyConfig>{},
    registeredComponents: {},
  }),
  getters: {
    getRegisteredComponents: (state): { [key: string]: any } => {
      return state.registeredComponents
    },
    getModuleBlueprintForType: (state) => (type: string) => {
      return state.config.moduleBlueprints[type]
    },
    getModuleBlueprints: (state): { [key: string]: any } =>
      state.config.moduleBlueprints,
    getGlobalSections: (state) => state.config?.globalSections,
    getGlobalModules: (state): { [key: string]: any } =>
      state.config?.globalModules,
    getBuilderConfig: (state) => state.config,
    getBuilderOptions: (state) => state.config.builder_options,
  },
  actions: {
    setConfig(config: BuildyConfig) {
      this.config = { ...config }
    },
    setGlobals(globals: { [key: string]: any }, type: string) {
      this.globals[type] = Object.assign({}, { ...globals })
    },
    setRegisteredComponents(payload: { [key: string]: any }) {
      this.registeredComponents = { ...payload }
    },
  },
})
