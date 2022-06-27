<template>
  <div class="replicator-field">
    <draggable
      :list="values"
      group="replicator-sets"
      item-key="_uuid"
      class="replicator-draggable h-100 d-flex flex-grow flex-column gap-5 group">
      <template #item="{ element }">
        <replicator-set
          v-if="fields"
          :fields="fields"
          :value="element"
          @input="updateSet" />
      </template>
    </draggable>
    <button class="btn btn-primary mt-4" type="button" @click="addSet">
      Add Set
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, toRefs, computed } from "vue"
import { useFieldType, commonProps } from "../useFieldType"
import { useBuilderStore } from "../../../stores/builder"
import { generateID } from "../../../utils/id"
const props = defineProps({ ...commonProps })

const { getFieldDefaultsForType } = useBuilderStore()

const { handle, moduleType } = toRefs(props)
const values = ref(
  props.modelValue ? props.modelValue : [{ _uuid: generateID() }]
)

const set: any = computed(() => getFieldDefaultsForType(moduleType.value))
const fields = set.value.fields[handle?.value || ""]?.fields

const addSet = () => {
  values.value.push({ _uuid: generateID() })
}

const updateSet = ($event: any, index: number) => {
  alert("test")
  values.value.splice(index, 1, [...$event])
}

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

watch(
  values,
  (newValue) => {
    update(newValue)
    console.log(newValue)
  },
  { deep: true }
)
</script>
<style></style>
