<script lang="ts" setup>
import { useFieldType } from "./useFieldType";
import { toRefs } from "vue";

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

const { handle, config, value } = toRefs(props);

const textConfigDefaults = {
  input_type: "text",
};

const configWithDefaults = { ...textConfigDefaults, ...config.value };

const emit = defineEmits(["update", "updateMeta"]);
const { update } = useFieldType(emit);
</script>

<template>
  <div>
    <input
      :handle="handle"
      :type="configWithDefaults.input_type"
      :value="value"
      @input="update(($event?.target as HTMLInputElement)?.value)"
      placeholder="text fieldtype"
    />
  </div>
</template>

<style lang=""></style>
