<script lang="ts" setup>
import { ref } from "vue";

const props = defineProps({
  component: {
    type: Object,
    required: true,
  },
});

const settingsToggle = ref(false);
const settingsOpen = ref(false);
const component = ref(props.component);

const handleOpen = () => {
  settingsOpen.value = true;
  console.log(settingsOpen.value);
};

const handleClose = () => {
  settingsOpen.value = false;
  settingsToggle.value = false;
  console.log(settingsOpen.value);
};
</script>
<template>
  <font-awesome-icon
    :icon="['fas', 'pen-to-square']"
    @click="settingsToggle = true"
    width="15"
    height="15"
    fill="currentColor"
    data-bs-toggle="offcanvas"
    :data-bs-target="`#module-${component.uuid}`"
    aria-controls="offcanvasRight"
    class="flex cursor-pointer pulse"
  ></font-awesome-icon>
  <div
    v-show="settingsToggle"
    v-on="{
      'shown.bs.offcanvas': handleOpen,
      'hidden.bs.offcanvas': handleClose,
    }"
    class="offcanvas offcanvas-end text-600"
    tabindex="-1"
    :id="`module-${component.uuid}`"
    aria-labelledby="offcanvasRightLabel"
    style="--bs-offcanvas-width: 50rem"
  >
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
      <button
        @click="settingsToggle = false"
        type="button"
        class="btn-close"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
      ></button>
    </div>
    <div class="offcanvas-body">
      <p v-if="settingsOpen">Settings for the {{ component.type }}</p>
    </div>
  </div>
</template>
<style lang=""></style>
