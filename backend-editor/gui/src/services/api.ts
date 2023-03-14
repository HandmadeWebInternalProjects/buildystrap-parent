import axios from "axios"

import { TOKEN } from "./token"

const instance = ({
  baseURL = "",
  headers = { "X-WP-Nonce": TOKEN || "" },
} = {}) =>
  axios.create({
    baseURL: baseURL,
    headers: {
      "Content-Type": "application/json",
      ...headers,
    },
  })

// Use for regular WP REST routes
const wp_base = instance({
  baseURL: "/wp-json/wp/v2",
})

const buildy_base = instance({
  baseURL: "/wp-json/buildy/v1",
})

const wp_acf = instance({
  baseURL: "/wp-json/acf/v3",
})

export { wp_base, wp_acf, buildy_base }
