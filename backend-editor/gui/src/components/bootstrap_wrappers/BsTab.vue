<template lang="">
  <div
    class="tab-pane"
    :class="{ active: active }"
    :id="`tab-${_uuid}`"
    role="tabpanel"
    :aria-labelledby="`tab-${_uuid}`"
    tabindex="0"
    ref="root"
    >
    <slot />
  </div>
</template>
<script setup lang="ts">
import { computed, toRefs, onMounted, ref } from "vue"
import { Popover } from "bootstrap"
const props = defineProps({
  name: String,
  uuid: String,
  active: { type: Boolean, default: false },
})

const { active } = toRefs(props)

const _uuid = computed(() => {
  return props.uuid || props.name
})

const root = ref<HTMLElement | null>(null)

onMounted(() => {
  const popoverTriggerList: any = root?.value && root.value.querySelectorAll('[data-bs-toggle="popover"]')
  const popoverList: any = [...popoverTriggerList].map(
    (popoverTriggerEl) =>
      new Popover(popoverTriggerEl, {
        placement: "right",
        trigger: "focus",
      })
  )
})
</script>
