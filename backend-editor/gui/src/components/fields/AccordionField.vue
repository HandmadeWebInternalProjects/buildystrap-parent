<script lang="ts" setup>
import { toRefs, computed } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { generateID } from "../../utils/id"

const props = defineProps({ ...commonProps })

const { handle, config, modelValue } = toRefs(props)

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const addItem = () => {
  values.value = [...values.value, { _uuid: generateID() }]
}

const removeItem = (uuid: string) => {
  if (confirm("Are you sure you want to delete this item?")) {
    values.value = values.value.filter((el) => el._uuid !== uuid)
  }
}

const values = computed({
  get() {
    return modelValue?.value || []
  },
  set(newVal: Array<any>) {
    update(newVal)
  },
})
</script>

<template>
  <div>
    <label class="w-100">
      <field-label :label="config.label || handle" />
      <draggable
        v-if="values.length"
        :list="values"
        group="accordion-items"
        item-key="_uuid"
        class="accordion"
        id="accordionExample">
        <template #item="{ element }">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                :data-bs-target="`#item-${element._uuid}`"
                aria-expanded="true"
                aria-controls="collapseOne">
                <span class="flex-grow-1">{{
                  element.title || element._uuid
                }}</span>
                <font-awesome-icon
                  class="delete-icon d-block px-3"
                  icon="trash"
                  @click.prevent="removeItem(element._uuid)" />
              </button>
            </h2>
            <div
              :id="`item-${element._uuid}`"
              class="accordion-collapse collapse"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <field-group>
                  <text-field
                    handle="accordion-title"
                    v-model="element['title']" />
                  <richtext-field
                    handle="accordion-content"
                    v-model="element['content']"
                    :uuid="element._uuid" />
                </field-group>
              </div>
            </div>
          </div>
        </template>
      </draggable>
      <button @click="addItem" type="button" class="btn btn-primary mt-3">
        Add item
      </button>
    </label>
  </div>
</template>
