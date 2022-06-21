import { defineStore } from "pinia";

export const useBuilderStore = defineStore({
  id: "builder",
  state: () => ({
    fieldDefaults: <{ [key: string]: any }>{
      "text-module": [
        {
          type: "text-fieldtype",
          handle: "text",
          config: {
            input_type: "text",
          },
        },
      ],
    },
  }),
  getters: {
    getFieldDefaults: (state) => (type: string) =>
      state.fieldDefaults[type] || {},
  },
  actions: {
    setFieldDefaults(payload: { [key: string]: any }) {
      this.fieldDefaults = { ...payload };
    },
  },
});
