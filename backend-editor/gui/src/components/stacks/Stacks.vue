<template>
  <div class="stacks-on-stacks">
    <portal-target
      v-for="(stack, i) in getStacks"
      :key="`stack-${stack.uid}-${i}`"
      :name="`stack-${i}`" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted, onUnmounted } from "vue"
import { useStacks } from "./useStacks"

const { getStacks } = useStacks()
// import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';

onMounted(() => {
  window.Buildy.$bus.on("stacks.hit-area-clicked", (depth: number) => {
    for (let count = getStacks.value.length; count > depth; count--) {
      if (!getStacks.value[count - 1]?.exposed?.runCloseCallback()) {
        return
      }
    }
  })

  // disableBodyScroll(this.$el);
})

onUnmounted(() => {
  window.Buildy.$bus.off("stacks.hit-area-clicked")
  // enableBodyScroll(this.$el);
  // clearAllBodyScrollLocks();
})
</script>

<style lang="scss">
.stacks-on-stacks {
  position: fixed;
  inset: 0;
  z-index: 10000;

  > .vue-portal-target {
    position: absolute;
    inset: 0;
  }

  .stack-container {
    position: absolute;
    inset: 0;
    transition: all 0.2s ease;
  }

  .stack-overlay {
    background: black;
    position: absolute;
    inset: 0;
    z-index: 99;
    opacity: 0.2;
    pointer-events: none;
    transition: all 0.1s ease;

    &.stack-overlay-fade-enter-active,
    &.stack-overlay-fade-leave-to {
      opacity: 0;
    }
  }

  .stack-hit-area {
    position: absolute;
    inset: 0;
    cursor: pointer;
    z-index: 100;
  }

  .stack-content {
    background: white;
    height: 100%;
    position: relative;
    z-index: 101;
    transition: all 0.3s ease;

    &.stack-slide-enter-active,
    &.stack-slide-leave-to {
      transform: translateX(100%);
      opacity: 0;
    }
    &.stack-slide-leave-to {
      transform: translateX(100%);
    }
  }

  .hovering .stack-content {
    transform: translateX(-16px);
  }

  .breadcrumb svg {
    display: none !important;
  }
}

@media all and (max-width: 980px) {
  .stacks-on-stacks .stack-container {
    transform: translateX(100%) !important;
    left: 0 !important;
  }
}
</style>
