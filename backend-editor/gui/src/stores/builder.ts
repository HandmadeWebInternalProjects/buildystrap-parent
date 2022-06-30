import { defineStore } from "pinia"

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    registeredComponents: {},
    fieldDefaults: <{ [key: string]: any }>{},
    globals: <{ [key: string]: any }>{
      sections: {},
      modules: {},
    },
  }),
  getters: {
    getRegisteredComponents: (state): { [key: string]: any } => {
      return state.registeredComponents
    },
    getModuleBlueprintForType: (state) => (type: string) => {
      return state.fieldDefaults[type]
    },
    getModuleBlueprints: (state) => state.fieldDefaults,
    getGlobalSections: (state) => state.globals.sections,
    getGlobalModules: (state) => state.globals.modules,
  },
  actions: {
    setGlobals(globals: { [key: string]: any }, type: string) {
      this.globals[type] = { ...globals }
    },
    setRegisteredComponents(payload: { [key: string]: any }) {
      this.registeredComponents = { ...payload }
    },
    setModuleBlueprints(payload: { [key: string]: any }) {
      this.fieldDefaults = { ...payload }
    },
  },
})
