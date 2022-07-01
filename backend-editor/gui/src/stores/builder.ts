import { defineStore } from "pinia"

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    config: {},
    registeredComponents: {},
    blueprints: <{ [key: string]: any }>{},
    globals: <{ [key: string]: any }>{
      sections: <{ [key: string]: any }>{},
      modules: <{ [key: string]: any }>{},
    },
  }),
  getters: {
    getRegisteredComponents: (state): { [key: string]: any } => {
      return state.registeredComponents
    },
    getModuleBlueprintForType: (state) => (type: string) => {
      return state.blueprints[type]
    },
    getModuleBlueprints: (state) => state.blueprints,
    getGlobalSections: (state) => state.globals.sections,
    getGlobalModules: (state): { [key: string]: any } => state.globals.modules,
    getConfig: (state) => state.config,
  },
  actions: {
    setConfig(config: { [key: string]: any }) {
      const { moduleBlueprints, ...rest } = config
      this.config = { ...rest }
      this.blueprints = moduleBlueprints
    },

    setGlobals(globals: { [key: string]: any }, type: string) {
      this.globals[type] = Object.assign({}, { ...globals })
    },
    setRegisteredComponents(payload: { [key: string]: any }) {
      this.registeredComponents = { ...payload }
    },
  },
})
