import { defineStore } from "pinia"

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    registeredComponents: {},
    fieldDefaults: <{ [key: string]: any }>{
      "text-module": {
        icon: "fa-solid fa-paragraph",
        fields: {
          title: {
            type: "text-field",
            handle: "title",
            config: {
              input_type: "text",
              display: "Title",
            },
          },
        },
      },
      "blurb-module": {
        icon: "fa-solid fa-anchor",
        fields: {
          title: {
            type: "text-field",
            handle: "title",
            config: {
              input_type: "text",
              display: "Title",
            },
          },
          url: {
            type: "text-field",
            handle: "url",
            config: {
              input_type: "text",
              display: "URL",
            },
          },
          role: {
            type: "checkboxes-field",
            handle: "role",
            config: {
              display: "Role",
              options: { primary: "Primary", secondary: "Secondary" },
            },
          },
          content: {
            type: "richtext-field",
            handle: "content",
            config: {
              display: "Content",
            },
          },
          image: {
            type: "media-field",
            handle: "image",
            config: {
              display: "Image",
              multiple: true,
            },
          },
        },
      },
      "replicator-test": {
        icon: "fa-solid fa-wand-magic-sparkles",
        fields: {
          set_handle: {
            type: "replicator-field",
            handle: "set_handle",
            config: {
              display: "Set Handle",
            },
            fields: {
              title: {
                type: "text-field",
                handle: "title",
                config: {
                  input_type: "text",
                  display: "Title",
                },
              },
              role: {
                type: "checkboxes-field",
                handle: "role",
                config: {
                  display: "Role",
                  options: { primary: "Primary", secondary: "Secondary" },
                },
              },
              content: {
                type: "richtext-field",
                handle: "content",
                config: {
                  display: "Content",
                },
              },
              image: {
                type: "media-field",
                handle: "image",
                config: {
                  display: "Image",
                },
              },
            },
          },
        },
      },
    },
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
