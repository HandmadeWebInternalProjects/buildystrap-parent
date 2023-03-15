import { ref, onMounted } from "vue"
import { buildy_base } from "@/services/api"
import { fetchPost } from "@/services/post"

export const usePost = (id: string, postType: string) => {
  const post = ref(null)
  const featuredImageURL = ref(null)

  const renderPostModule = async () => {
    const { data } = await buildy_base.get(`/render_module/${id}`)
    return data?.html
  }

  onMounted(async () => {
    post.value = await fetchPost(id, postType)
  })

  return {
    post,
    featuredImageURL,
    renderPostModule,
  }
}
