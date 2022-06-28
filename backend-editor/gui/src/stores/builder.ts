import { defineStore } from "pinia"

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    registeredComponents: {},
    fieldDefaults: <{ [key: string]: any }>{},
  }),
  getters: {
    getRegisteredComponents: (state): { [key: string]: any } => {
      return state.registeredComponents
    },
    getFieldDefaultsForType: (state) => (type: string) => {
      return state.fieldDefaults[type]
    },
    getFieldDefaults: (state) => state.fieldDefaults,
  },
  actions: {
    setRegisteredComponents(payload: { [key: string]: any }) {
      this.registeredComponents = { ...payload }
    },
    setFieldDefaults(payload: { [key: string]: any }) {
      this.fieldDefaults = { ...payload }
    },
  },
})
