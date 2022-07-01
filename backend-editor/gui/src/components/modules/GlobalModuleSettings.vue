<template lang="">
  <div class="d-flex flex-column gap-3">
    <ul class="m-0 p-0">
      <li>id: {{ component.global_id }}</li>
      <li>admin label: {{ component.config.adminLabel }}</li>
    </ul>

    <a
      target="_blank"
      :href="`${config.site_url}/wp-admin/post.php?post=${component.global_id}&action=edit&classic-editor`"
      >Edit Global</a
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
