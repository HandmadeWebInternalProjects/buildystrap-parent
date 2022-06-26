import { onMounted } from "vue";
import type { Component, ComputedRef } from "vue";

interface ModuleInterface {
  save(value: any): void;
  updateMeta(value: any): void;
}

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
