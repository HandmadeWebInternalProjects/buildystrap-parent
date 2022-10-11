<script lang="ts" setup>
import { toRefs, ref, onMounted, onUnmounted } from "vue"
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
  window.jQuery(document).on("wplink-open", () => {
    const url = document.querySelector<HTMLInputElement>("#wp-link-url")
    const title = document.querySelector<HTMLInputElement>("#wp-link-text")
    const target = document.querySelector<HTMLInputElement>("#wp-link-target")

    if (config.value?.hideTitle === true) {
      title?.closest(".wp-link-text-field")?.classList.add("d-none")
    }

    url && (url.value = link.value?.url ?? "")
    title && (title.value = link.value?.title ?? "")
    target && (target.checked = link.value?.target === "_blank")
  })

  wpLinkRef.value?.open(`hidden-${uuid.value}`)

  window.jQuery(document).on("wplink-close", () => {
    const linkData = {
      url: document.querySelector<HTMLInputElement>("#wp-link-url")?.value,
      title: document.querySelector<HTMLInputElement>("#wp-link-text")?.value,
      target: document.querySelector<HTMLInputElement>("#wp-link-target")
        ?.checked
        ? "_blank"
        : "",
    }

    document
      .querySelector<HTMLInputElement>("#wp-link-text")
      ?.closest(".wp-link-text-field")
      ?.classList.remove("d-none")

    link.value = linkData

    // Emit to parent
    update(linkData)
    window.jQuery(document).off("wplink-open")
    window.jQuery(document).off("wplink-close")
  })
}

onUnmounted(() => {
  window.jQuery(document).off("wplink-open")
  window.jQuery(document).off("wplink-close")
})
</script>

<template>
  <div class="link-field">
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover" />
    <input type="text" :id="`hidden-${uuid}`" class="d-none" />
    <div class="input-group">
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
        @focus="openLinkBrowser"
        type="text"
        v-model="link.url"
        class="form-control"
        aria-label="url" />
      <span v-if="link.title && !config?.hideTitle" class="input-group-text">{{
        link.title
      }}</span>
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

<style lang="scss">
.link-field {
  .input-group * {
    font-size: 14px !important;
  }
}
.wp-link-text-field.d-none {
  display: none !important;
}
</style>
