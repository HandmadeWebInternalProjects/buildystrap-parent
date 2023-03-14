import { ref, onMounted } from "vue"
import { wp_base, buildy_base } from "@/services/api"

export const usePost = (id: string, postType: string) => {
  const post = ref(null)
  const featuredImageURL = ref(null)

  const fetchPost = async () => {
    const { data } = await wp_base.get(`/${postType}/${id}?_embed`)
    post.value = data

    // Set featured Image
    if (data?._embedded?.["wp:featuredmedia"]) {
      featuredImageURL.value =
        data._embedded[
          "wp:featuredmedia"
        ][0].media_details.sizes.full.source_url
    }
  }

  const renderPostModule = async () => {
    const { data } = await buildy_base.get(`/render_module/${id}`)
    return data?.html
  }

  onMounted(() => {
    fetchPost()
  })

  return {
    post,
    featuredImageURL,
    renderPostModule,
  }
}
