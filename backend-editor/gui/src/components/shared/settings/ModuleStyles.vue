<template>
  <div>
    <select-field
      v-if="moduleStyles.length"
      handle="box_model_top"
      type="text"
      :config="{
        label: false,
        options: moduleStyles,
        multiple: true,
      }"
      v-model="value" />
      <div v-else>
        <p class="text-muted mb-0">No module styles found.</p>
        <p class="text-muted mb-0">You can add module styles under <a @click.prevent="setLocalStorage" href="" target="_blank">Buildystrap Settings</a>.</p>
        <p class="text-muted mb-0">Use "<strong>{{ component?.type }}</strong>" as the Module Name.</p>
      </div>
  </div>
</template>
<script lang="ts" setup>
import { computed, inject } from "vue"
import { useFieldType } from "../../fields/useFieldType"
import { storeToRefs } from "pinia"
import { useBuilderStore } from "@/stores/builder"

const { getModuleStyles } = storeToRefs(useBuilderStore())

type ModuleStyle = {
  module_name: string
  styles: {
    [key: string]: any
  }[]
}

// inject component
const component = inject<{ [key: string]: any }>("component")

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(["update:modelValue"])

const { update } = useFieldType(emit)

const moduleStyles = computed((): any => {
  const sharedStyles =
    getModuleStyles?.value?.find(
      (moduleStyle: ModuleStyle) => moduleStyle.module_name === "shared-module"
    ) || []

  const hasModuleStyles =
    getModuleStyles?.value.find((moduleStyle: ModuleStyle) =>
      moduleStyle.module_name.includes(component?.type)
    ) || []

  const combined_styles = [
    ...(hasModuleStyles?.styles || []),
    ...(sharedStyles?.styles || []),
  ]

  return combined_styles ? combined_styles : null
})

const value = computed({
  get() {
    return Object.keys(props?.modelValue).length ? props?.modelValue : null
  },
  set(val) {
    update(val)
  },
})

const setLocalStorage = () => {
  localStorage.setItem("acf", JSON.stringify({'tabs-options' : [6]}))
  window.open("/wp-admin/admin.php?page=buildystrap-settings", "_blank")
}
</script>
<style lang=""></style>
