import { useBuilderStore } from "@/stores/builder"

export const useACFOptions = () => {
  const { getBuilderOptions } = useBuilderStore()

  const getBoxModelSizing = () => {
    const boxModelSizing = getBuilderOptions?.structure.box_model_sizing

    return boxModelSizing.map((obj: { label: string; value: string }) => {
      return {
        ...obj,
        label: obj.label ? obj.label + " - " + obj.value : obj.value,
        value: obj.label.toLowerCase() || obj.value,
      }
    })
  }

  const getSizing = (type: string) => {
    const sizing = getBuilderOptions?.structure[type]
    return sizing.map((obj: { label: string; value: string }) => {
      return {
        ...obj,
        label: obj.label ? obj.label + " - " + obj.value : obj.value,
        value: obj.label.toLowerCase() || obj.value,
      }
    })
  }

  const getThemeColours = () => {
    const themeColours = getBuilderOptions?.theme_colours
    const additionalColours = getBuilderOptions?.additional_colours
    return [
      ...Object.keys(themeColours),
      ...additionalColours.map(
        (el: { label: string; value: any }) =>
          el?.label.toLowerCase() || el?.value
      ),
    ]
  }

  const getTypography = () => {
    const bodyFont = getBuilderOptions?.structure?.typography?.body_font
    const headingFont = getBuilderOptions?.structure?.typography?.heading_font
    const additionalFonts =
      getBuilderOptions?.structure?.typography?.additional_fonts
    return [bodyFont, headingFont, ...additionalFonts]
  }

  const getFontSize = () => {
    const fontSize = getBuilderOptions?.structure?.font_size
    return fontSize.map((obj: { label: string; value: string }) => {
      return {
        ...obj,
        label: obj.label ? obj.label + " - " + obj.value : obj.value,
        value: obj.label.toLowerCase() || obj.value,
      }
    })
  }

  return {
    getBoxModelSizing,
    getSizing,
    getThemeColours,
    getTypography,
    getFontSize,
  }
}
