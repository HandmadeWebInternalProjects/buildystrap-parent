import { computed } from "vue"
import { useBuilderStore } from "@/stores/builder"
import { storeToRefs } from "pinia"

export const useClipboard = (component: any) => {
  const { updatePasteLocations } = useBuilderStore()
  const { getPasteLocations } = storeToRefs(useBuilderStore())

  const isValidPasteLocation = computed(() => {
    return getPasteLocations.value.some((type) => {
      return component.type.includes(type)
    })
  })

  const updateClipboard = (newClip: string, context: string) => {
    navigator.clipboard.writeText(newClip).then(
      () => {
        if (!context || typeof context !== "string") {
          return updatePasteLocations([])
        }
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
      },
      (err) => {
        console.log(`copy failed: ${err}`)
      }
    )
  }

  const copyToClipboard = () => {
    const clipboardModule = JSON.stringify(component)
    const type = "text/plain"
    const blob = new Blob([clipboardModule], { type })
    const data = [new ClipboardItem({ [type]: blob })]

    navigator.clipboard.write(data).then(
      () => {
        updateClipboard(clipboardModule, component.type)
      },
      () => {
        console.log("copy failed")
      }
    )
  }

  const pasteFromClipboard = (cb: (newModule: { type: string }) => void) => {
    navigator.clipboard.readText().then((clipboardText) => {
      const newModule: { type: string } = JSON.parse(clipboardText)
      if (isValidPasteLocation.value) {
        cb(newModule)
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
        updatePasteLocations([])
      },
      () => {
        /* clipboard write failed */
      }
    )
  }

  const readFromClipboard = () => {
    navigator.clipboard
      .readText()
      .then((clipboardText) => {
        if (!clipboardText) {
          updatePasteLocations([""])
          return
        }
        const newModule = tryParseJSON(clipboardText)

        if (newModule && newModule.type) {
          updatePasteLocations([newModule.type])
        } else {
          updatePasteLocations([])
        }
      })
      .catch((err) => console.log(err))
  }

  return {
    isValidPasteLocation,
    updateClipboard,
    copyToClipboard,
    pasteFromClipboard,
    tryParseJSON,
    emptyClipboard,
    readFromClipboard,
  }
}
