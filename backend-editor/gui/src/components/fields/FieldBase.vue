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
      :default="field?.config?.default"
      :placeholder="
        config?.responsive && responsivePlaceholder(value, handle, bp)
      "
      :values="parent_values || value"
      v-model="fieldValue"
      :is="field.type"
      @update-meta="updateMeta" />
  </div>
</template>

<script lang="ts" setup>
import Validator from "../../field-conditions/Validator"
import { useFieldType, commonProps } from "./useFieldType"
import { computed, ref, inject, watch, nextTick, onMounted } from "vue"
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

// Inject "parent_values" from a replicator set if exists
const parent_values = inject("parent_values", ref(false))

const root = ref<HTMLElement | null>(null)

const emit = defineEmits(["updateMeta", "update:modelValue"])

const { update, responsivePlaceholder } = useFieldType(emit)

const value = computed({
  get() {
    return props?.modelValue || {}
  },
  set(val) {
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
      if (
        !value.value[props.handle] ||
        typeof value.value[props.handle] === "string"
      ) {
        value.value[props.handle] = {}
      }
      value.value[props.handle][bp.value] = val
    } else {
      value.value[props.handle] = val
    }
  },
})

const enablePopovers = () => {
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
    enablePopovers()
  }
})

onMounted(() => {
  /**
   * Checks if the field is responsive and initializes the value for the specified breakpoint.
   * If the value for the specified breakpoint is not set, it uses the default value from the field configuration.
   *
   * @param {Object} props - The component props.
   * @param {Object} value - The value object.
   * @param {string} handle - The field handle.
   * @param {string} bp - The breakpoint value.
   */
  if (props.field.config?.default) {
    if (props.field.config?.responsive) {
      if (!value.value[props.handle]) {
        value.value[props.handle] = {}
      }
      if (!value.value[props.handle]?.md) {
        value.value[props.handle].md = props.field.config?.default
      }
    } else {
      value.value[props.handle] = !value.value[props.handle]
        ? props.field.config?.default
        : value.value[props.handle]
    }
  }

  enablePopovers()
})
</script>

<style></style>
