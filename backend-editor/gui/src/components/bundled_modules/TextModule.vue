<script lang="ts" setup>
import { ref, toRefs, onBeforeMount } from "vue";
import { useModule, ModuleProps } from "../bundled_modules/useModule";

const props = defineProps(ModuleProps);

const fields = ref(props.fields);

const emit = defineEmits(["update", "updateMeta"]);
const { save } = useModule();

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
    addField(field: typeof ModuleProps): void {
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
