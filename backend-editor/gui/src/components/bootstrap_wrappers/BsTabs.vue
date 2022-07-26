<template lang="">
  <div>
    <ul class="nav nav-pills pb-2 border-bottom" id="myTab" role="tablist">
      <li
        v-for="tab in tabs"
        :key="tab?.props?.uuid ?? tab?.props?.name"
        class="nav-item"
        role="presentation">
        <button
          class="nav-link"
          :class="[{ active: tab?.props?.active }]"
          data-bs-toggle="tab"
          :data-bs-target="`#tab-${tab?.props?.uuid ?? tab?.props?.name}`"
          type="button"
          role="tab"
          aria-controls="content"
          aria-selected="true">
          {{ tab?.props?.name }}
        </button>
      </li>
    </ul>
    <div class="tab-content card mt-3 p-4 rounded">
      <slot />
    </div>
  </div>
</template>
<script setup lang="ts">
import { computed, useSlots } from "vue"

const slots = useSlots()

const tabs = computed(() => {
  if (slots?.default) {
    return slots
      .default()
      .reduce((acc: { [key: string]: any }[], slot: { [key: string]: any }) => {
        if (slot?.type.__name !== "BsTab") {
          acc.push(...(slot?.children || []))
        } else {
          acc.push(slot)
        }
        return acc
      }, [])
  }
  return []
})
</script>
<style lang=""></style>
