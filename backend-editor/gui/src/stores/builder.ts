import { defineStore } from "pinia"

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    registeredComponents: {},
    fieldDefaults: <{ [key: string]: any }>{
      "text-module": {
        icon: "fa-solid fa-paragraph",
        fields: [
          {
            type: "text-field",
            handle: "title",
            config: {
              input_type: "text",
              display: "Title",
            },
          },
        ],
      },
      "blurb-module": {
        icon: "fa-solid fa-anchor",
        fields: [
          {
            type: "text-field",
            handle: "title",
            config: {
              input_type: "text",
              display: "Title",
            },
          },
          {
            type: "text-field",
            handle: "url",
            config: {
              input_type: "text",
              display: "URL",
            },
          },
          {
            type: "checkboxes-field",
            handle: "role",
            config: {
              display: "Role",
              options: { primary: "Primary", secondary: "Secondary" },
            },
          },
        ],
      },
    },
  }),
  getters: {
    getRegisteredComponents: (state) => {
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
