<script lang="ts" setup>
import { withProps, useFieldType } from "./useFieldType";
import { toRefs } from "vue";

const props = defineProps({ ...withProps() });
const { handle, config, value } = toRefs(props);

const textConfigDefaults = {
  input_type: "text",
};

config.value = { ...textConfigDefaults, ...config.value };

const emit = defineEmits(["update", "updateMeta"]);
const { update } = useFieldType(emit);
</script>

<template>
  <div>
    <input
      :handle="handle"
      :type="config.input_type"
      :value="value"
      @input="update(($event?.target as HTMLInputElement)?.value)"
      placeholder="text fieldtype"
    />
  </div>
</template>

<style lang=""></style>
