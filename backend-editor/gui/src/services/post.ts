import { wp_base, buildy_base } from "@/services/api"

const getWpNonce = (): string | undefined => {
  if (typeof window === "undefined") return undefined
  return (window as any).wpApiSettings?.nonce || (window as any).Buildy?.nonce
}

export const fetchPost = async (id: string, postType: string) => {
  const { data } = await wp_base.get(`/${postType}/${id}?_embed`)
  return data
}

export const fetchLibraryPost = async (id: string) => {
  const headers: Record<string, string> = {}
  const nonce = getWpNonce()

  if (nonce) {
    headers["X-WP-Nonce"] = nonce
  }

  const { data } = await buildy_base.get(`/fetch-library-post/${id}`, { headers })
  return data
}
