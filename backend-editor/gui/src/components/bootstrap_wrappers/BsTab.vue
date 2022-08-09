<template lang="">
  <div
    class="tab-pane"
    :class="{ active: active }"
    :id="`tab-${_uuid}`"
    role="tabpanel"
    :aria-labelledby="`tab-${_uuid}`"
    tabindex="0">
    <slot />
  </div>
</template>
<script setup lang="ts">
import { computed, toRefs } from "vue"
const props = defineProps({
  name: String,
  uuid: String,
  active: { type: Boolean, default: false },
})

const { active } = toRefs(props)

const _uuid = computed(() => {
  return props.uuid || props.name
})
</script>
