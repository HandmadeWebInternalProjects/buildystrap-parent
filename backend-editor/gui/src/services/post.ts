import { wp_base, buildy_base } from "@/services/api"

export const fetchPost = async (id: string, postType: string) => {
  const { data } = await wp_base.get(`/${postType}/${id}?_embed`)
  return data
}

export const fetchLibraryPost = async (id: string) => {
  const { data } = await buildy_base.get(`/fetch-library-post/${id}`)
  return data
}
