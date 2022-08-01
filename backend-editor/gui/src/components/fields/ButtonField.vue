<script lang="ts" setup>
import { toRefs, ref, computed, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const { handle, config, modelValue } = toRefs(props)
const value = ref(modelValue?.value || {})

watch(value.value, (newValue) => {
  update(newValue)
})

const baseStyles = {
  Primary: "btn-primary",
  Secondary: "btn-secondary",
  Success: "btn-success",
  Danger: "btn-danger",
  Warning: "btn-warning",
  Info: "btn-info",
  Light: "btn-light",
  Dark: "btn-dark",
  Link: "btn-link",
}

const sizes = {
  "btn-sm": "Small",
  "btn-lg": "Large",
}

const updateStyleValue = (property: string, action: string) => {
  let style = value?.value?.["style"] || false
  if (!style) return
  const styleValue = style.match(/[^-]*$/)[0]
  value.value["style"] =
    action === "add" ? `btn-${property}-${styleValue}` : `btn-${styleValue}`
}

const outlined = computed(() => {
  return value.value["outlined"] || false
})

watch(outlined, () => {
  updateStyleValue("outline", outlined.value ? "add" : "remove")
})

const styles = computed(() => {
  if (outlined.value) {
    return Object.entries(baseStyles).reduce((acc: any, [key, value]: any) => {
      acc[`btn-outline-${key.split("-")[1]}`] = `Outline ${value}`
      return acc
    }, {})
  }
  return baseStyles
})
</script>

<template>
  <div>
    <div class="d-flex gap-4 align-items-center justify-content-between">
      <field-label
        v-if="config.label !== false"
        :label="config?.label !== undefined ? config.label : handle"
        :popover="config?.popover" />
      <button
        type="button"
        class="btn"
        :class="[value['style'], value['size']]"
        :disabled="value['disabled']">
        {{ value["text"] || "Example" }}
      </button>
    </div>
    <field-group class="mb-4">
      <text-field handle="text" v-model="value['text']" />
      <text-field handle="url" v-model="value['url']" />
      <div class="d-flex gap-4">
        <select-field
          class="flex-grow-1"
          handle="style"
          v-model="value['style']"
          :key="styles"
          :config="{
            options: styles,
          }" />
        <select-field
          class="flex-grow-1"
          handle="size"
          v-model="value['size']"
          :config="{
            options: sizes,
          }" />
      </div>
      <div class="d-flex gap-4">
        <toggle-field
          handle="outlined"
          v-model="value['outlined']"
          :config="{ label: 'Outlined' }" />
        <toggle-field
          handle="disabled"
          v-model="value['disabled']"
          :config="{ label: 'Disabled' }" />
      </div>
    </field-group>
  </div>
</template>

<style lang=""></style>
