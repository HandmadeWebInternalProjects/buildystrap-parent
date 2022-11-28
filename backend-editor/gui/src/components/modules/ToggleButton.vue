<template>
  <button
    type="button"
    @click="toggle"
    @keyup.prevent.space.enter="toggle"
    class="btn btn-sm btn-toggle"
    :class="[{ active: state }]"
    data-toggle="button"
    data-enabled-text="On"
    data-disabled-text="Off"
    :aria-pressed="state"
    autocomplete="off">
    <div class="handle"></div>
  </button>
</template>

<script setup lang="ts">
import { ref, computed } from "vue"
const emit = defineEmits(["input"])

const props = defineProps({
  value: {
    type: Boolean,
    default: false,
  },
  readOnly: {
    type: Boolean,
    default: () => false,
  },
})

const readOnly = ref(props.readOnly)
const state = computed(() => props.value)

emit("input", state.value)

const toggle = () => {
  if (!readOnly.value) {
    emit("input", !state.value)
  }
}
</script>

<style lang="scss" scoped>
@use "sass:math";

// Colors
$brand-primary: var(--bs-indigo);
$brand-secondary: var(--bs-orange);
$gray: #6b7381;
$gray-light: lighten($gray, 15%);
$gray-lighter: lighten($gray, 30%);

// Button Colors
$btn-default-color: $gray;
$btn-default-bg: $gray-lighter;

// Toggle Sizes
$toggle-default-size: 1.75rem;
$toggle-default-label-width: 4rem;
$toggle-default-font-size: 1rem;

@mixin toggle-color(
  $color: $btn-default-color,
  $bg: $btn-default-bg,
  $active-bg: $brand-primary
) {
  color: $color;
  &,
  &:focus,
  &:hover {
    background: $bg;
  }
  &:before,
  &:after {
    color: $color;
  }
  &.active {
    &,
    &:hover {
      background-color: $active-bg;
    }
  }
}

@mixin toggle-mixin(
  $size: $toggle-default-size,
  $margin: $toggle-default-label-width,
  $font-size: $toggle-default-font-size
) {
  // color: $color;
  // background: $bg;
  margin: 0 $margin;
  padding: 0;
  position: relative;
  border: none;
  height: $size;
  width: $size * 2;
  border-radius: 5px;

  &:focus,
  &.focus {
    &,
    &.active {
      outline: none;
    }
  }

  &:before,
  &:after {
    line-height: $size;
    width: $margin;
    text-align: center;
    font-weight: 600;
    // color: $color;
    font-size: $font-size;
    letter-spacing: 2px;
    position: absolute;
    bottom: 0;
    transition: opacity 0.25s;
  }
  &:before {
    content: attr(data-disabled-text);
    left: -$margin;
  }
  &:after {
    content: attr(data-enabled-text);
    right: -$margin;
    opacity: 0.5;
  }

  > .handle {
    position: absolute;
    top: math.div(($size * 0.25), 2);
    left: math.div(($size * 0.25), 2);
    width: $size * 0.75;
    height: $size * 0.75;
    border-radius: 5px;
    background: #fff;
    transition: left 0.25s;
  }
  &.active {
    transition: background-color 0.25s;
    > .handle {
      left: $size + math.div(($size * 0.25), 2);
      transition: left 0.25s;
    }
    &:before {
      opacity: 0.5;
    }
    &:after {
      opacity: 1;
    }
  }

  &.btn-sm {
    &:before,
    &:after {
      line-height: $size;
      color: #fff;
      letter-spacing: 0.75px;
      left: calc($size * 0.275);
      width: calc($size * 1.55);
    }
    &:before {
      text-align: right;
    }
    &:after {
      text-align: left;
      opacity: 0;
    }
    &.active {
      &:before {
        opacity: 0;
      }
      &:after {
        opacity: 1;
      }
    }
  }

  &.btn-xs {
    &:before,
    &:after {
      display: none;
    }
  }
}
#app {
  .btn-toggle {
    @include toggle-mixin;
    @include toggle-color;

    &.btn-lg {
      @include toggle-mixin($size: 2.5rem, $font-size: 1rem, $margin: 5rem);
    }

    &.btn-sm {
      @include toggle-mixin($font-size: 0.65rem, $margin: 0);
    }

    &.btn-xs {
      @include toggle-mixin($size: 1rem, $margin: 0);
    }

    &.btn-secondary {
      @include toggle-color($active-bg: $brand-secondary);
    }
  }
}
</style>
