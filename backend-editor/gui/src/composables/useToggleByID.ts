import { ref, computed } from "vue"

export const activeItem = ref("")

export const useToggleByID = (uuid: string) => {
  const isOpen = computed(() => {
    return activeItem.value === uuid
  })

  const toggleItem = () => {
    isOpen.value ? (activeItem.value = "") : (activeItem.value = uuid)
  }

  return {
    toggleItem,
    isOpen,
  }
}
