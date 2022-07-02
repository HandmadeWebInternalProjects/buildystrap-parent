import { ref } from "vue"

const breakpoints = ["xs", "sm", "md", "lg", "xl"]
const breakpoint = ref(breakpoints[0])

export const useBreakpoints = () => {
  const updateBreakpoint = (val: string) => {
    breakpoint.value = val
  }

  return {
    breakpoints,
    breakpoint,
    updateBreakpoint,
  }
}
