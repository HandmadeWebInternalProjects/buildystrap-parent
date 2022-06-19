import { onMounted } from "vue";
import type { Component, ComputedRef } from "vue";

interface ModuleInterface {
  save(value: any): void;
  updateMeta(value: any): void;
}

export const ModuleProps = {
  type: {
    type: String,
    default: "",
  },
  uuid: {
    type: String,
    default: "",
  },
  handle: {
    type: String,
    default: "",
  },
  value: {
    type: [String, Object, Array],
    default: "",
  },
  fields: {
    type: Array,
    default: [],
  },
  config: {
    type: Object,
    default: [],
  },
  meta: {
    type: Object,
    default: [],
  },
};

export const useModule = (): ModuleInterface => {
  const save = (value: any): void => {
    // Set deep value
  };

  const updateMeta = (value: any): void => {
    // Set meta value
  };

  return {
    save,
    updateMeta,
  };
};
