import { useBuilderStore } from "@/stores/builder"

export const useACFOptions = () => {
  const { getAcfOptions } = useBuilderStore()

  const getBoxModelSizing = () => {
    const boxModelSizing = getAcfOptions?.structure.box_model_sizing
    return boxModelSizing
      ? Object.values(boxModelSizing).map((el: any) => el.value)
      : Array.from({ length: 11 }, (_, i) => i)
  }

  const getSizing = (type: string) => {
    const hasOptions = getAcfOptions?.structure[type]
    let defaults: { [key: string]: any } = {
      width: [
        "none",
        "auto",
        "0%",
        "25%",
        "33.33%",
        "50%",
        "66.66%",
        "75%",
        "100%",
        "100vw",
      ],
      height: ["50vh", "100vh"],
    }
    return hasOptions
      ? Object.values(hasOptions).map((el: any) => el.value)
      : defaults[type]
  }

  const getThemeColours = (str: string) => {
    const userOptions = getAcfOptions?.structure.theme_colours
    let options: number[] = []
    if (userOptions) {
      userOptions.forEach(function (item: { [x: string]: number }) {
        Object.keys(item).forEach(function (key) {
          options.push(item[key])
        })
      })
    }
    return options
  }

  return {
    getBoxModelSizing,
    getSizing,
    getThemeColours,
  }
}
