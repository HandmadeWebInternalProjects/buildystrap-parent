import { ref, computed } from "vue";
import type { ComponentInternalInstance, ComputedRef, Ref } from "vue";

const stacks: Ref<ComponentInternalInstance[]> = ref([]);

interface StacksInterface {
  getStacks: ComputedRef<ComponentInternalInstance[]>;
  addStack(vm: ComponentInternalInstance | null): void;
  removeStack(vm: ComponentInternalInstance | null): void;
}

export const useStacks = (): StacksInterface => {
  const addStack = (vm: ComponentInternalInstance) => {
    stacks.value.push(vm);
  };

  const getStacks: ComputedRef<ComponentInternalInstance[]> = computed(() => {
    return stacks.value;
  });

  const removeStack = (vm: ComponentInternalInstance) => {
    const i: number = stacks.value.findIndex((el) => el.uid === vm.uid);
    if (i === null || i === undefined) return;
    stacks.value.splice(i, 1);
  };

  return {
    addStack,
    removeStack,
    getStacks,
  };
};
