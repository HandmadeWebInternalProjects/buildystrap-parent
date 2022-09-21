<script setup lang="ts">
import vSelect from "vue-select"
import { useFieldType, commonProps } from "./useFieldType"
import { toRefs, computed } from "vue"
import "vue-select/dist/vue-select.css"

const props = defineProps({
  ...commonProps,
  loading: { type: Boolean, default: false },
})

const { handle, config, modelValue, placeholder } = toRefs(props)
const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, normaliseOptions } = useFieldType(emit)

const selected = computed({
  get() {
    return modelValue?.value
  },
  set(newVal) {
    update(newVal)
  },
})
const options = normaliseOptions(config.value.options) || []
</script>
<template>
  <div class="select-field position-relative">
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config?.popover"
      :responsive="config?.responsive" />
    <v-select
      :loading="props.loading"
      :multiple="config?.multiple"
      :taggable="config?.taggable"
      :reduce="(option: any) => option?.value || option?.label"
      v-model="selected"
      :name="handle"
      :disabled="config.disabled || false"
      :placeholder="placeholder || config.placeholder"
      :options="options">
    </v-select>
  </div>
</template>
<style lang="scss">
.select-field {
  --vs-controls-size: 0.75;
  --vs-actions-padding: 0 6px 0 3px;
  --vs-dropdown-option--active-bg: var(--bs-indigo);
  text-transform: capitalize;

  &.sub-label {
    label {
      font-size: 0.7em;
    }
  }

  .vs__dropdown-toggle {
    background: white;
    padding: 0;

    .vs__selected-options {
      padding: 0;

      .vs__selected {
        margin: 2px;

        .vs__deselect {
          display: flex;
          padding-left: 5px;
          transform: scale(0.8);
        }
      }

      .vs__search {
        border: 0;

        &:focus {
          border-color: var(--bs-indigo);
          box-shadow: 0 0 0 1px var(--bs-indigo);
        }
      }
    }

    .vs__actions {
      .vs__clear {
        display: flex;
        transform: scale(0.8);

        svg {
          vertical-align: initial !important;
        }
      }
    }
  }

  .vs__dropdown-menu {
    top: 100%;
    padding: 0 !important;

    .vs__dropdown-option {
      padding: 5px 10px !important;
      margin: 0 !important;
    }
  }

  .v-select:not(.vs--open) .vs__selected {
    background: var(--bs-gray-100);
    border: 1px solid #ccc;
    padding: 0 0.6em;
  }
}
</style>
