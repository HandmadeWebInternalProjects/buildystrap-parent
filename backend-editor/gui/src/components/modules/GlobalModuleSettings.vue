<template lang="">
  <div class="d-flex flex-column gap-3">
    <p class="text-600">
      This is a global module, which means it's linked from the Buildy Global
      Modules in the sidebar. This could be used in multiple places around the
      site and any changes made to it will be applied to all places.
    </p>
    <ul class="m-0 p-0">
      <li><strong>Title:</strong> {{ component.config.adminLabel }}</li>
      <li>
        <strong>Global Module ID:</strong>
        <span class="d-inline-block px-2 py-1 ms-2 border bg-100 rounded">{{
          component.global_id
        }}</span>
      </li>
    </ul>

    <a
      target="_blank"
      :href="`${config.site_url}/wp-admin/post.php?post=${component.global_id}&action=edit&classic-editor`"
      >Edit {{ component.config.adminLabel }}</a
    >
  </div>
</template>

<script setup lang="ts">
import { onMounted } from "vue"
import { storeToRefs } from "pinia"
import { useBuilderStore } from "@/stores/builder"
const props = defineProps({
  type: {
    type: String,
    required: true,
  },
  component: {
    type: Object,
    required: true,
  },
})

const { config } = storeToRefs(useBuilderStore())

onMounted(async (): Promise<void> => {
  // If we need to fetch this particular global modules data in the future
  // const res = await fetch(
  //   `http://blank.local/wp-json/buildy/v1/get_global?global_id=${props.component.global_id}`
  // )
  // const { data } = await res.json()
  // globalModuleComponent.value = Object.assign(props.component, { value: data })
  // console.log(globalModuleComponent.value)
})
</script>
<style lang=""></style>
