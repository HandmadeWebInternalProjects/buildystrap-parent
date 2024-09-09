<template lang="">
  <div class="card border-0 bg-100">
    <div
      v-if="label !== false"
      class="card-header border-0 d-flex align-items-center"
      data-bs-toggle="collapse"
      :data-bs-target="`#collapse-${uuid}`"
      :aria-expanded="isActive"
      :aria-controls="uuid">
      <field-label :label="label" :popover="popover" />
      <breakpoint-switcher
        v-if="breakpointHandle"
        :handle="breakpointHandle"
        class="ms-auto" />
    </div>
    <div class="collapse" :class="{ show: isActive }" :id="`collapse-${uuid}`">
      <div
        class="card-body rounded-bottom d-flex flex-column"
        :class="`gap-${gap}`">
        <slot name="body"></slot>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { onMounted, ref } from "vue"
import { generateID } from "@/utils/id"

const props = defineProps({
  label: {
    type: [String, Boolean],
    required: true,
  },
  popover: {
    type: String,
    required: false,
    default: "",
  },
  breakpointHandle: {
    type: String,
    required: false,
  },
  gap: {
    type: String,
    required: false,
    default: "3",
  },
  active: {
    type: Boolean,
    required: false,
    default: false,
  },
  uuid: {
    type: String,
    required: false,
  },
})

const uuid = ref(props.uuid)

const isActive = ref(props.active)

onMounted(() => {
  if (!uuid.value) {
    uuid.value = generateID()
  }
})
</script>
<style lang="scss">
.card {
  max-width: none;
  margin: 0;
  padding: 0;
}
.card-header {
  min-height: 45px;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
.card-body {
  .sub-label {
    label {
      font-size: 0.7em;
    }
  }
}
</style>
