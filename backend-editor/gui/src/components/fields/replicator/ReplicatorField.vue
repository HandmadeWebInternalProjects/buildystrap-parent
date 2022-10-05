<template>
  <div class="accordion replicator-field">
    <!-- <div class="d-flex gap-4 mb-3 justify-content-center">
      <span @click="collapseAll" type="button">Collapse All</span>
      <span @click="openAll" type="button">Open All</span>
    </div> -->
    <draggable
      :list="values"
      @change="handleDragChange"
      group="replicator-sets"
      item-key="_uuid"
      class="replicator-draggable h-100 d-flex flex-grow flex-column group">
      <template #item="{ element, index }">
        <replicator-set
          v-if="Object.keys(field.fields).length"
          :field="field"
          :value="element"
          :index="index"
          :module-type="moduleType"
          :meta="meta[index]"
          @remove-set="removeSet(index)"
          @update-meta="onMetaUpdated($event, index)"
          @input="updateSet" />
      </template>
    </draggable>
    <button class="btn btn-sm btn-primary mt-3" type="button" @click="addSet">
      Add {{ `${field?.config?.label ?? 'Item'}` }}
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, watch, toRefs, computed, onMounted } from "vue"
import { useFieldType, commonProps } from "../useFieldType"
import { useBuilderStore } from "../../../stores/builder"
import { generateID } from "../../../utils/id"
import { findNestedObject } from "../../../utils/objects"
const props = defineProps({ ...commonProps })

const { getModuleBlueprintForType } = useBuilderStore()

const { handle, moduleType } = toRefs(props)

const values = ref(
  props.modelValue ? props.modelValue : [{ _uuid: generateID() }]
)

const set: any = computed(() => getModuleBlueprintForType(moduleType.value))
const field = reactive<any>({ fields: {} })

const meta = ref(values.value.map(() => ({ collapsed: false })))

onMounted(() => {
  Object.assign(field, findNestedObject(set.value, handle?.value))
  if (props?.meta) {
    props.meta.forEach((val: any, i: number) => meta.value.splice(i, 1, val))
  }
  // console.log(moduleType.value)
})

const addSet = () => {
  values.value.push({ _uuid: generateID() })
  meta.value.push({ collapsed: false })
  updateMeta(meta.value)
}

const removeSet = (index: number) => {
  values.value.splice(index, 1)
  meta.value.splice(index, 1)
  updateMeta(meta.value)
}

const updateSet = ($event: any, index: number) => {
  values.value.splice(index, 1, [...$event])
}

const onMetaUpdated = ($event: any, index: number) => {
  meta.value[index]
    ? Object.assign(meta.value[index], $event)
    : meta.value.push($event)

  updateMeta(meta.value)
}

const handleDragChange = (e: { [key: string]: any }) => {
  if (e.moved) {
    const { newIndex, oldIndex }: { newIndex: number; oldIndex: number } =
      e.moved
    const plucked = meta.value.splice(oldIndex, 1)[0]

    meta.value.splice(newIndex, 0, plucked)

    updateMeta(meta.value)
  }
}

const collapseAll = () => {
  meta.value.forEach((meta: any) => {
    meta.collapsed = true
  })
  updateMeta(meta.value)
}

const openAll = () => {
  meta.value.forEach((meta: any) => {
    meta.collapsed = false
  })
  updateMeta(meta.value)
}

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update, updateMeta } = useFieldType(emit)

watch(
  values,
  (newValue) => {
    update(newValue)
  },
  { deep: true }
)
</script>
