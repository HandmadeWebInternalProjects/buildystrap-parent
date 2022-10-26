<template lang="">
  <div class="accordion-item">
    <h2 class="accordion-header d-flex p-0">
      <div class="sortable-handle bg-purple-500"></div>
      <button
        class="accordion-button collapsed"
        type="button"
        data-bs-toggle="collapse"
        :data-bs-target="`#item-${_uuid}`">
        <span class="flex-grow-1 pe-3">{{ title || _uuid }}</span>
        <font-awesome-icon
          class="delete-icon d-block ps-3 order-2"
          icon="trash"
          @click.prevent="removeItem(_uuid)" />
      </button>
    </h2>
    <div
      :id="`item-${_uuid}`"
      class="accordion-collapse collapse"
      data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <slot />
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { computed } from "vue"
import { generateID } from "@/utils/id"
import { faAlignCenter } from "@fortawesome/free-solid-svg-icons"
const props = defineProps({
  title: String,
  uuid: String,
})

const emit = defineEmits(["remove"])

const _uuid = computed(() => {
  return props.uuid || generateID()
})

const removeItem = (_uuid: string) => {
  emit("remove", _uuid)
}
</script>
<style lang="scss">
#app {

  .accordion-item {
    overflow: hidden;

    .accordion-header {

      .sortable-handle {
        justify-content: center;
      }
    }
  }
}
</style>
