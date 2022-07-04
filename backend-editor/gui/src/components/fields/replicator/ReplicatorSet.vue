<template lang="">
  <div class="p-3 bg-100 rounded position-relative">
    <field-label
      @click="collapsed = !collapsed"
      v-if="collapsed"
      :label="value[preview] || 'Preview not set'" />
    <font-awesome-icon
      class="position-absolute cursor-pointer collapse-toggle"
      :icon="collapsed ? 'chevron-down' : 'chevron-up'"
      @click="collapsed = !collapsed" />
    <font-awesome-icon
      class="position-absolute cursor-pointer remove-set"
      icon="trash"
      @click="removeSet" />
    <div v-show="!collapsed">
      <field-group>
        <component
          v-for="(field, key) in fields"
          :key="key"
          :handle="key"
          :type="field.type"
          :module-type="moduleType"
          :config="field.config || {}"
          v-model="value[key]"
          :uuid="value._uuid"
          :is="field.type" />
      </field-group>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, computed } from "vue"
const props = defineProps({
  value: {
    type: Object,
    required: true,
  },
  fields: {
    type: Object,
    required: true,
  },
  preview: {
    type: String,
    required: false,
  },
  moduleType: {
    type: String,
    required: false,
  },
  meta: { type: Object, required: false },
})
const fields = ref(props.fields)
const meta = computed(() => props.meta)

const emit = defineEmits(["input", "updateMeta", "removeSet"])

const removeSet = () => {
  if (
    window.confirm(
      `Are you sure you want to remove this set? (${
        props.preview ? value.value[props.preview] : ""
      })`
    )
  ) {
    emit("removeSet")
  }
}

const value = computed({
  get() {
    return props.value || {}
  },
  set(newValue) {
    emit("input", newValue)
  },
})

const collapsed = computed({
  get() {
    return meta?.value?.collapsed || false
  },
  set(newValue) {
    emit("updateMeta", { collapsed: newValue })
  },
})
</script>
<style lang="scss">
.collapse-toggle {
  top: 1rem;
  right: 3rem;
}
.remove-set {
  top: 1rem;
  right: 1rem;
}
</style>
