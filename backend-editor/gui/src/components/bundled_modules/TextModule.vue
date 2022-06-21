<script lang="ts" setup>
import { reactive, onBeforeMount } from "vue";
import { storeToRefs } from "pinia";
import { useBuilderStore } from "../../stores/builder";
// import { useModule } from "../bundled_modules/useModule";

const props = defineProps({
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
    type: Object,
    default: "",
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  meta: {
    type: Object,
    default: () => ({}),
  },
});

const { getFieldDefaults } = useBuilderStore();

const fieldDefaults = getFieldDefaults(props.type);

// Temp, this will come from props or getDeep
const value = reactive(props.value);

const handleUpdate = (value: any) => {
  console.log(value);
};
</script>
<template lang="">
  <component
    v-for="field in fieldDefaults"
    :handle="field.handle"
    :config="field.config || {}"
    :key="field.handle"
    v-model="value[field.handle]"
    :is="field.type"
  />
</template>

<style lang=""></style>
