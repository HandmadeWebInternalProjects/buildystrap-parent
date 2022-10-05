<script lang="ts" setup>
import { toRefs, ref, computed, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { getThemeColours } = useBuilderOptions()
const props = defineProps({ ...commonProps })

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const { handle, config, uuid, modelValue } = toRefs(props)
const value = ref(modelValue?.value || {})

watch(value.value, (newValue) => {
  // console.log({ newValue })

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
  Small: "btn-sm",
  Large: "btn-lg",
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
    return Object.entries(baseStyles).reduce((acc: any, [value, key]: any) => {
      acc[`Outline ${value}`] = `btn-outline-${key.split("-")[1]}`
      return acc
    }, {})
  }
  return baseStyles
})
</script>

<template>
  <bs-card :label="config.label">
    <template v-slot:body>
      <field-group>
        <text-field class="g-col-12" handle="text" v-model="value['text']" :config="{ label: 'Title' }" />
        <link-field class="g-col-12" handle="url" v-model="value['url']" :uuid="uuid" :config="{ label: 'URL', hideTitle: true }" />
        <select-field
          class="g-col-12 w-100"
          handle="button-color"
          :config="{
            label: 'Text Color',
            options: getThemeColours(),
            taggable: true,
          }"
          v-model="value['color']" />
        <div class="g-col-12 grid gap-4" style="--bs-columns: 2;">
          <select-field
            class=""
            handle="style"
            v-model="value['style']"
            :key="styles"
            :config="{
              label: 'Background Colour',
              options: styles,
            }" />
          <select-field
            class=""
            handle="size"
            v-model="value['size']"
            :config="{
              options: sizes,
            }" />
        </div>
        <div class="g-col-12 d-flex justify-content-between align-items-center">
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
          <button
            type="button"
            class="preview-btn btn"
            :class="[value['style'], value['size']]"
            :style="{
              '--bs-btn-color': `var(--bs-${value['color']})`,
            }"
            :disabled="value['disabled']">
            {{ value["text"] || "Example" }}
          </button>
        </div>
      </field-group>
    </template>
  </bs-card>
    

</template>

<style lang="scss">
</style>
