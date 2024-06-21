<script lang="ts" setup>
import { toRefs, ref, computed, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"

import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { getThemeColours } = useBuilderOptions()

const props = defineProps({ ...commonProps })

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const { config, uuid, modelValue } = toRefs(props)
const value = ref(
  modelValue?.value || { type: config?.value?.default || "custom" }
)

watch(value.value, (newValue) => {
  if (newValue["type"] && newValue["type"] !== "custom") {
    delete newValue["style"]
    delete newValue["color"]
  }
  update(newValue)
})

const btnStyles = getThemeColours()

const sizes = {
  ...(config.value?.sizes || {}),
}

const spliceColorValues = (property: string, style: string, order = 1) => {
  let parts: string[] = style.split("-")
  if (parts.includes(property)) return style
  // Add property to the end after dash
  parts.splice(order, 0, property)
  return parts.join("-")
}

const unSpliceColorvalues = (property: string, style: string, order = 1) => {
  let parts = style.split("-")
  parts.splice(order, 1)
  return parts.join("-")
}

const updateStyleValue = (property: string, action: boolean) => {
  let style = value?.value?.["style"] || false
  let type = value?.value?.["type"] || false

  if (!style && !type) return

  if (action) {
    if (style) {
      value.value["style"] = spliceColorValues(property, style, 0)
    }
    if (type) {
      value.value["type"] = spliceColorValues(property, type)
    }
  } else {
    if (style) {
      value.value["style"] = unSpliceColorvalues(property, style, 0)
    }
    if (type) {
      value.value["type"] = unSpliceColorvalues(property, type)
    }
  }
}

const outlined = computed(() => {
  return value.value["outlined"] || false
})

watch(outlined, () => {
  updateStyleValue("outline", outlined.value)
})

const types = computed(() => {
  let types = { ...(config.value?.types ?? {}) }
  let processedTypes: any = Object.values(types).reduce(
    (acc: any, curr: any) => {
      const curr_processed = spliceColorValues("outline", curr)
      acc[curr_processed] = curr_processed
      return acc
    },
    {}
  )
  if (outlined.value) {
    return {
      Custom: "custom",
      ...processedTypes,
    }
  }

  return {
    Custom: "custom",
    ...(config.value?.types || {}),
  }
})
</script>

<template>
  <bs-card :label="config.label">
    <template v-slot:body>
      <field-group>
        <text-field
          class="g-col-12"
          handle="text"
          v-model="value['text']"
          :config="{ label: 'Title' }" />
        <link-field
          class="g-col-12"
          handle="url"
          v-model="value['url']"
          :uuid="uuid"
          :config="{ label: 'URL', hideTitle: true }" />
        <text-field
          class="g-col-12"
          handle="class"
          v-model="value['class']"
          :config="{ label: 'Button Class' }" />
        <select-field
          class="g-col-12"
          handle="type"
          :key="types"
          v-model="value['type']"
          :config="{
            label: 'Button Type',
            options: types,
          }" />

        <media-field
          class="g-col-12"
          handle="icon"
          v-model="value['icon']"
          :config="{ label: 'Icon' }" />

        <div
          v-if="!value?.['type'] || value?.['type'] === 'custom'"
          class="g-col-12 grid gap-4"
          style="--bs-columns: 2">
          <color-select-field
            handle="button-color"
            :config="{
              label: 'Text Color',
              taggable: true,
            }"
            v-model="value['color']" />
          <color-select-field
            handle="style"
            v-model="value['style']"
            :config="{
              label: 'Background Colour',
              options: btnStyles,
            }" />
        </div>
        <select-field
          class="g-col-12"
          handle="size"
          v-model="value['size']"
          :config="{
            options: sizes,
          }" />
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
            <toggle-field
              handle="target"
              v-model="value['target']"
              :config="{ label: 'Open in new tab?' }" />
          </div>
          <button
            type="button"
            class="preview-btn btn d-flex align-items-center gap-2"
            :class="[`btn-${value['style']}`, value['size'], value['type']]"
            :style="{
              '--bs-btn-color': `var(--bs-${value['color']})`,
            }"
            :disabled="value['disabled']">
            {{ value["text"] || "Example" }} 
            <span v-if="value['icon']">
              <async-img 
              v-for="icon in value['icon']"
              :key="icon.id"
              :id="icon.id"
              class="image-preview image-placeholder opacity-50 aspect-square" />
            </span>
          </button>
        </div>
      </field-group>
    </template>
  </bs-card>
</template>

<style lang="scss"></style>
