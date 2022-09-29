<script lang="ts" setup>
import { toRefs, ref, onMounted, onUnmounted } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const wpLinkRef = ref(window?.wpLink || {})
const link = ref(modelValue.value || "")

const openLinkBrowser = () => {
  wpLinkRef.value?.open()
}

onMounted(() => {
  jQuery(document).on("wplink-close", (event, data) => {
    const url = wpLinkRef.value?.getAttrs()?.href ?? ""
    link.value = url
    update(url)
  })
})

onUnmounted(() => {
  jQuery(document).off("wplink-close")
})
</script>

<template>
  <div>
    <text-field :handle="handle" v-model="link" @click="openLinkBrowser" />
  </div>
</template>

<style lang="scss"></style>
