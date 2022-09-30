<script lang="ts" setup>
import { toRefs, computed, onMounted, onUnmounted } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, uuid, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const wpLinkRef = ref(window?.wpLink || {})
const link = ref(
  modelValue?.value || {
    url: "",
    title: "",
    target: "",
  }
)

const openLinkBrowser = () => {
  wpLinkRef.value?.open(`hidden-${uuid.value}`)
}

onMounted(() => {
  window.jQuery(document).on("wplink-open", () => {
    const url = document.querySelector<HTMLInputElement>("#wp-link-url")
    const title = document.querySelector<HTMLInputElement>("#wp-link-text")
    const target = document.querySelector<HTMLInputElement>("#wp-link-target")

    url && (url.value = link.value?.url ?? "")
    title && (title.value = link.value?.title ?? "")
    target && (target.checked = link.value?.target === "_blank")
  })

  window.jQuery(document).on("wplink-close", () => {
    const linkData = {
      url: document.querySelector<HTMLInputElement>("#wp-link-url").value,
      title: document.querySelector<HTMLInputElement>("#wp-link-text").value,
      target: document.querySelector<HTMLInputElement>("#wp-link-target")
        .checked
        ? "_blank"
        : "",
    }

    link.value = linkData

    console.log(link.value)

    // Emit to parent
    update(linkData)
  })
})

onUnmounted(() => {
  window.jQuery(document).off("wplink-open")
  window.jQuery(document).off("wplink-close")
})
</script>

<template>
  <div>
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <text-area :id="`hidden-${uuid}`"></text-area>
    <div @click="openLinkBrowser" class="input-group mb-3">
      <span class="input-group-text">
        <font-awesome-icon
          :icon="['fas', 'link']"
          :title="link.url"
          width="25"
          height="25"
          fill="currentColor"
          class="cursor-pointer pulse">
        </font-awesome-icon>
      </span>
      <input
        type="text"
        v-model="link.title"
        class="form-control"
        aria-label="url" />
      <span v-if="link.target === '_blank'" class="input-group-text">
        <font-awesome-icon
          :icon="['fas', 'arrow-up-right-from-square']"
          title="Open link in new tab"
          width="25"
          height="25"
          fill="currentColor"
          class="cursor-pointer pulse">
        </font-awesome-icon>
      </span>
    </div>
  </div>
</template>

<style lang="scss"></style>
