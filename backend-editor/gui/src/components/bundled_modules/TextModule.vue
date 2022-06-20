<script lang="ts" setup>
import { ref, onBeforeMount } from "vue";
import { useModule } from "../bundled_modules/useModule";

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
    type: [String, Object, Array],
    default: "",
  },
  fields: {
    type: Array,
    default: () => [],
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

const fields = ref(props.fields);

const handleUpdate = (value: any) => {
  console.log(value);
};

fields.value.push({
  type: "text-fieldtype",
  handle: "value",
  value: "Orig",
  config: { input_type: "email" },
});

onBeforeMount(() => {
  window.Buildy.$hooks.run("text-fieldtype-init", {
    fields,
    addField(field: typeof props): void {
      fields.value.push(field);
      console.log({ fields: fields.value });
    },
  });
});
</script>
<template lang="">
  <component
    v-for="field in fields"
    :handle="field.handle"
    :config="field.config ?? null"
    :key="field.handle"
    :value="field.value"
    :is="field.type"
    @update="handleUpdate"
  />
</template>

<style lang=""></style>
