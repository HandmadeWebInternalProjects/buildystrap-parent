<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
});

const component = ref(props.component);
const settingsToggle = ref(false);
const designToggle = ref(false);
</script>
<template>
  <font-awesome-icon
    :icon="['fas', 'pen-to-square']"
    @click="settingsToggle = true"
    width="15"
    height="15"
    fill="currentColor"
    aria-controls="offcanvasRight"
    class="flex cursor-pointer pulse"
  ></font-awesome-icon>
  <buildy-stack
    @close="(settingsToggle = false), (designToggle = false)"
    v-if="settingsToggle"
    half
    name="module-settings"
  >
    <div class="p-5">
      <component
        :is="component.type"
        :type="component.type"
        :value="component.value"
      />
      <div @click="designToggle = true" class="btn">Open Design Tab</div>
      <buildy-stack
        name="design-tab"
        half
        v-if="designToggle"
        @close="designToggle = false"
      >
        <div class="p-5">Design Tab</div>
      </buildy-stack>
    </div>
  </buildy-stack>
</template>
<style lang=""></style>
