import { reactive, computed } from "vue"

export const breakpoints = ["xs", "sm", "md", "lg", "xl", "xxl"]
const breakpoint = reactive<{ [key: string]: any }>({
  global: "xs",
})

export const useBreakpoints = (handle = "global") => {
  const bp = computed({
    get() {
      return breakpoint[handle] || "xs"
    },
    set(val) {
      breakpoint[handle] = val
    },
  })

  return {
    breakpoints,
    bp,
  }
}
