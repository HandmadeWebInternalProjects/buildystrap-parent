import { computed, ref } from "vue"
import { useBuilderStore } from "@/stores/builder"
import { storeToRefs } from "pinia"
import { Toast } from "bootstrap"

export const hasClipboardAccess = computed(() => !!navigator.clipboard)
export const hasPageInClipboard = ref(false)

export const useClipboard = (component: any) => {
  const { updatePasteLocations } = useBuilderStore()
  const { getPasteLocations } = storeToRefs(useBuilderStore())

  const isValidPasteLocation = computed(() => {
    return component?.type
      ? getPasteLocations.value.some((type) => component.type.includes(type))
      : hasPageInClipboard.value && Array.isArray(component.value)
  })

  const determinPasteLocations = (context: string) => {
    switch (true) {
      case context.includes("module"):
        updatePasteLocations(["module"])
        break
      case context.includes("section"):
        updatePasteLocations(["section", "GlobalSection"])
        break
      default:
        updatePasteLocations([context])
    }
  }

  const updateClipboard = (newClip: string, context: string) => {
    navigator.clipboard.writeText(newClip).then(
      () => {
        if (!context || typeof context !== "string") {
          return updatePasteLocations([])
        }

        determinPasteLocations(context)
      },
      (err) => {
        console.log(`copy failed: ${err}`)
      }
    )
  }

  const copyToClipboard = ($event, type: string = component.type) => {
    const clipboardModule = JSON.stringify(component)
    const copyType = "text/plain"
    const blob = new Blob([clipboardModule], { type: copyType })
    const data = [new ClipboardItem({ [copyType]: blob })]
    hasPageInClipboard.value = false

    navigator.clipboard.write(data).then(
      () => {
        updateClipboard(clipboardModule, type)
      },
      () => {
        console.log("copy failed")
      }
    )
  }

  const copyPageToClipboard = () => {
    const clipboardModule = JSON.stringify(component.value)
    const copyType = "text/plain"
    const blob = new Blob([clipboardModule], { type: copyType })
    const data = [new ClipboardItem({ [copyType]: blob })]

    navigator.clipboard.write(data).then(
      () => {
        updateClipboard(clipboardModule, "page")
        hasPageInClipboard.value = true
      },
      () => {
        console.log("copy failed")
      }
    )
  }

  const pasteFromClipboard = (cb: (newModule: any) => void) => {
    navigator.clipboard.readText().then(async (clipboardText) => {
      const newModule: { type: string } = JSON.parse(clipboardText)
      if (isValidPasteLocation.value) {
        await Promise.resolve(cb(newModule))
        emptyClipboard()
      } else {
        alert(`Can only paste ${newModule.type} with other ${newModule.type}s'`)
      }
    })
  }

  const tryParseJSON = (jsonString: string) => {
    if (jsonString) {
      try {
        const o = JSON.parse(jsonString)

        // Handle non-exception-throwing cases:
        // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
        // but... JSON.parse(null) returns null, and typeof null === "object",
        // so we must check for that, too. Thankfully, null is falsey, so this suffices:
        if (o && typeof o === "object") {
          return o
        }
      } catch (e) {
        console.log("Clipboard does not contain valid JSON")
      }

      return false
    }
  }

  const emptyClipboard = () => {
    navigator.clipboard.writeText("<empty clipboard>").then(
      () => {
        hasPageInClipboard.value = false
        updatePasteLocations([])
      },
      () => {
        /* clipboard write failed */
      }
    )
  }

  const readFromClipboard = (toastEL: any = null) => {
    navigator.clipboard
      .readText()
      .then((clipboardText) => {
        if (!clipboardText) {
          updatePasteLocations([])
          return
        }
        hasPageInClipboard.value = false
        const newModule = tryParseJSON(clipboardText)
        if (!newModule) {
          return emptyClipboard()
        }

        if (newModule && newModule?.type) {
          determinPasteLocations(newModule.type)
        } else {
          if (Array.isArray(newModule)) {
            hasPageInClipboard.value = true
            updatePasteLocations(["page"])
          }
          updatePasteLocations([])
        }
        if (toastEL !== null) {
          const toast = new Toast(toastEL)
          toast.show()
        }
      })
      .catch((err) => console.log(err))
  }

  return {
    isValidPasteLocation,
    updateClipboard,
    copyToClipboard,
    copyPageToClipboard,
    pasteFromClipboard,
    tryParseJSON,
    emptyClipboard,
    readFromClipboard,
    hasClipboardAccess,
  }
}
