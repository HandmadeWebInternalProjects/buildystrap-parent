import { useBuilderStore } from "@/stores/builder"

export const useBuilderOptions = () => {
  const { getBuilderOptions } = useBuilderStore()

  const getBoxModelSizing = () => {
    const boxModelSizing = getBuilderOptions?.structure.box_model_sizing || []

    return boxModelSizing.filter((el: any) => el).map((obj: { label: string; value: string }) => ({
      label: obj?.label ? `${obj.label} (${obj?.value})` : obj?.value,
      value: obj?.value ? obj.value.toLowerCase() : obj?.value,
    }))
  }

  const getSizing = (type: string) => {
    const sizing = getBuilderOptions?.structure[type] || []
    return sizing.filter((el: any) => el).map((obj: { label: string; value: string }) => {
      return {
        label: obj?.label ? `${obj.label} (${obj?.value})` : obj?.value ?? type,
        value: obj?.value ? obj.value.toLowerCase() : type,
      }
    })
  }

  const getThemeColours = () => {
    const themeColours = getBuilderOptions?.theme_colours || []
    const additionalColours = getBuilderOptions?.additional_colours || []
    return [
      ...Object.keys(themeColours),
      ...additionalColours.filter((el: any) => el).map((el: { label: string; value: any }) =>
        el?.label ? el.label.toLowerCase() : el?.value || []
      ),
    ]
  }

  const getTypography = () => {
    const bodyFont =
      getBuilderOptions?.typography?.body_font.value || "sans-serif"
    const headingFont =
      getBuilderOptions?.typography?.heading_font.value || "serif"
    const additionalFonts =
      getBuilderOptions?.typography?.additional_fonts || []
    return [bodyFont, headingFont, ...additionalFonts].filter((el) => el)
  }

  const getFontSize = () => {
    const fontSize = getBuilderOptions?.typography?.font_size || []

    return fontSize.filter((el: any) => el).map((obj: { label: string; value: string }) => ({
      ...obj,
      label: obj?.label ? obj.label : obj?.value ?? "",
      value: obj?.value ? obj.value.toLowerCase() : "",
    }))
  }

  return {
    getBoxModelSizing,
    getSizing,
    getThemeColours,
    getTypography,
    getFontSize,
  }
}
