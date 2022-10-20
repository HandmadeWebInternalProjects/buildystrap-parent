<script lang="ts" setup>
import { toRefs, ref, computed, watch } from "vue"
import { useFieldType, commonProps } from "./useFieldType"

import { useBuilderOptions } from "@/composables/useBuilderOptions"

const { getThemeColours } = useBuilderOptions()

const props = defineProps({ ...commonProps })

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const { config, uuid, modelValue } = toRefs(props)
const value = ref(modelValue?.value || {})

watch(value.value, (newValue) => {
  update(newValue)
})

const btnStyles = getThemeColours()

const sizes = {
  Small: "btn-sm",
  Large: "btn-lg",
}

const updateStyleValue = (property: string, action: boolean) => {
  let style = value?.value?.["style"] || false

  if (!style) return

  if (action) {
    value.value["style"] = `${property}-${style}`
  } else {
    value.value["style"] = style.replace(`${property}-`, "")
  }
}

const outlined = computed(() => {
  return value.value["outlined"] || false
})

watch(outlined, () => {
  updateStyleValue("outline", outlined.value)
})

const styles = computed(() => {
  if (outlined.value) {
    return btnStyles.map((value) => `outline-${value}`)
  }
  return btnStyles
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
        <color-select-field
          class="g-col-12 w-100"
          handle="button-color"
          :config="{
            label: 'Text Color',
            taggable: true,
          }"
          v-model="value['color']" />
        <div class="g-col-12 grid gap-4" style="--bs-columns: 2">
          <color-select-field
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
              <toggle-field
              handle="target"
              v-model="value['target']"
              :config="{ label: 'Open in new tab?' }" />
          </div>
          <button
            type="button"
            class="preview-btn btn"
            :class="[`btn-${value['style']}`, value['size']]"
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

<style lang="scss"></style>
