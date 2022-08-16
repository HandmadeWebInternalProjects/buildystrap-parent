<template>
  <div>
    <v-spinner v-if="!src" class="w-100 h-100 text-500"></v-spinner>
    <img class="w-100" :id="`img-${id}`" v-if="src" :src="src" />
  </div>
</template>
<script setup lang="ts">
import { onMounted, ref } from "vue"

const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  },
  size: {
    type: String,
    default: "thumbnail",
  },
})

const src = ref(null)

const getImageSrc = async (id: number | string) => {
  if (!id) return ""
  let attachment
  attachment = await Promise.resolve(window.wp.media.attachment(id))
  if (attachment) {
    attachment = await attachment.fetch()
    console.log({ attachment })
    attachment =
      attachment?.sizes?.["thumbnail"]?.url ?? attachment?.sizes?.["full"]?.url
  }
  return attachment
}

onMounted(async () => {
  src.value = await getImageSrc(props.id)
})
</script>
<style lang=""></style>
