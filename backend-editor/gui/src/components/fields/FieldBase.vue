<template>
  <div
    v-if="showField"
    :class="`${field.config?.class ?? 'g-col-12'}`"
    ref="root">
    <component
      :type="field.type"
      :module-type="moduleType"
      :config="field.config || {}"
      :key="handle"
      :handle="handle"
      :meta="meta"
      :uuid="uuid"
      :placeholder="
        config?.responsive && responsivePlaceholder(value, handle, bp)
      "
      :values="value"
      v-model="fieldValue"
      :is="field.type"
      @update-meta="updateMeta" />
  </div>
</template>

<script lang="ts" setup>
import Validator from "../../field-conditions/Validator"
import { useFieldType, commonProps } from "./useFieldType"
import { computed, ref, watch, nextTick } from "vue"
import { Popover } from "bootstrap"
import { useBreakpoints } from "../../composables/useBreakpoints"

const { bp } = useBreakpoints("global")

const props = defineProps({
  ...commonProps,
  field: {
    type: Object,
    required: true,
  },
  moduleType: {
    type: String,
    required: false,
  },
  handle: {
    type: String,
    required: true,
  },
})

const root = ref<HTMLElement | null>(null)

const emit = defineEmits(["updateMeta", "update:modelValue"])

const { update, responsivePlaceholder } = useFieldType(emit)

const value = computed({
  get() {
    return props?.modelValue || {}
  },
  set(val) {
    console.log({ val })
    update(val)
  },
})

const fieldValue = computed({
  get() {
    return props.field.config?.responsive
      ? value.value[props.handle]?.[bp.value] || undefined
      : value.value[props.handle]
  },
  set(val) {
    if (props.field.config && props.field.config.responsive) {
      if (!value.value[props.handle] || typeof value.value[props.handle] === 'string') {
        value.value[props.handle] = {};
      }
      value.value[props.handle][bp.value] = val;
    } else {
      value.value[props.handle] = val;
    }
  },
})

const showField = computed(() => {
  if (!props.field.config) return true
  const validator = new Validator(props?.field?.config, value.value, {}, "base")
  return validator.passesConditions()
})

const updateMeta = (meta: any) => {
  emit("updateMeta", meta)
}

watch(showField, async (val) => {
  if (val) {
    await nextTick()
    const popoverTriggerList: any =
      root?.value && root.value.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList: any = [...popoverTriggerList].map(
      (popoverTriggerEl) =>
        new Popover(popoverTriggerEl, {
          placement: "right",
          trigger: "focus",
        })
    )
  }
})
</script>

<style></style>
