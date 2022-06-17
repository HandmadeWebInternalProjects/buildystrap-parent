<template>
  <portal :to="portalName" :order="depth">
    <div
      class="stack-container"
      :class="{
        'stack-is-current': isTopStack,
        hovering: isHovering,
        'p-1 shadow-lg': full,
      }"
      :style="{
        zIndex: (depth + 1) * 1000,
        transform: `translateX(${leftOffset}px)`,
      }"
    >
      <transition name="stack-overlay-fade">
        <div
          class="stack-overlay"
          v-if="visible"
          :style="{ left: `-${leftOffset}px` }"
        />
      </transition>

      <div
        class="stack-hit-area"
        :style="{ left: `-${offset}px` }"
        @click="clickedHitArea"
        @mouseenter="mouseEnterHitArea"
        @mouseout="mouseOutHitArea"
      />

      <transition name="stack-slide">
        <div ref="stackContent" class="stack-content shadow-lg" v-if="visible">
          <slot name="default" :depth="depth" :close="close" />
        </div>
      </transition>
    </div>
  </portal>
</template>

<script lang="ts" setup>
import {
  ref,
  toRefs,
  computed,
  onBeforeMount,
  onMounted,
  onUnmounted,
  getCurrentInstance,
} from "vue";
import type { Ref } from "vue";
import { useStacks } from "./useStacks";

// as inline type
const emit = defineEmits(["close"]);

const { getStacks, addStack, removeStack } = useStacks();

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  beforeClose: {
    type: Function,
    default: () => true,
  },
  narrow: {
    type: Boolean,
  },
  half: {
    type: Boolean,
  },
  full: {
    type: Boolean,
  },
});

const { half, narrow, full, beforeClose } = toRefs(props);

const vm = getCurrentInstance();
const depth: Ref<number> = ref(0);
const portalName: Ref<string | null> = ref(null);
// const escBinding = ref(null);

const isTopStack = computed(() => {
  console.log(getStacks.value.length, depth.value);
  return getStacks.value.length === depth.value;
});

const offset = computed(() => {
  if (isTopStack.value && narrow.value) {
    return window.innerWidth - 400;
  } else if (isTopStack.value && half.value) {
    return window.innerWidth / 2;
  }

  // max of 200px, min of 80px
  return Math.max(400 / (getStacks.value.length + 1), 80);
});

const leftOffset = computed(() => {
  if (full.value) {
    return 0;
  }

  if (isTopStack.value && (narrow.value || half.value)) {
    return offset.value;
  }

  return offset.value * depth.value;
});

const hasChild = computed(() => {
  return getStacks.value.length > depth.value;
});

const isHovering: Ref<boolean | null> = ref(null);

onBeforeMount(async () => {
  depth.value = getStacks.value.length + 1;
  portalName.value = `stack-${depth.value - 1}`;
  addStack(vm);

  window.Buildy.$bus.on(
    `stacks.${depth.value}.hit-area-mouseenter`,
    () => (isHovering.value = true)
  );
  window.Buildy.$bus.on(
    `stacks.${depth.value}.hit-area-mouseout`,
    () => (isHovering.value = false)
  );
  // this.escBinding = this.$keys.bindGlobal("esc", this.close);
});

onUnmounted(() => {
  removeStack(vm);
  window.Buildy.$bus.off(`stacks.${depth.value}.hit-area-mouseenter`);
  window.Buildy.$bus.off(`stacks.${depth.value}.hit-area-mouseout`);
  // this.escBinding.destroy();
});

const clickedHitArea = () => {
  window.Buildy.$bus.emit(`stacks.hit-area-clicked`, depth.value - 1);
};

const mouseEnterHitArea = () => {
  window.Buildy.$bus.emit(`stacks.${depth.value - 1}.hit-area-mouseenter`);
};

const mouseOutHitArea = () => {
  window.Buildy.$bus.emit(`stacks.${depth.value - 1}.hit-area-mouseout`);
};

const runCloseCallback = () => {
  const shouldClose = beforeClose.value();

  if (!shouldClose) return false;

  close();

  return true;
};

const visible: Ref<boolean | null> = ref(null);
const stackContent = ref<HTMLElement | null>(null);
const close = () => {
  visible.value = false;

  stackContent?.value?.addEventListener(
    "transitionend",
    () => {
      emit("close");
    },
    { once: true }
  );
};

onMounted(() => {
  setTimeout(() => {
    visible.value = true;
  }, 10);
});

defineExpose({
  runCloseCallback,
  hasChild,
});
</script>
