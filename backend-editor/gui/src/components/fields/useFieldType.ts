import { breakpoints } from "../../composables/useBreakpoints"

type FieldTypeInterface = {
  update(value: any): void
  updateMeta(value: any): void
  normaliseOptions(options: any): { value: string; label: string }[]
  filterOutEmptyValues(val: { [key: string]: any }): {
    [key: string]: any
  }
  responsivePlaceholder(values: any, key: string | number, bp: string): string
}

export const commonProps = {
  type: {
    type: String,
    default: "",
  },
  handle: {
    type: String,
    required: true,
  },
  moduleType: {
    type: String,
    default: "",
  },
  uuid: {
    type: String,
    default: "",
  },
  modelValue: {
    type: null,
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  meta: {
    type: [Object, Array],
  },
}

export const useFieldType = (emit: any): FieldTypeInterface => {
  const update = (value: any) => {
    emit("update:modelValue", value)
  }

  const updateMeta = (value: any) => {
    emit("updateMeta", value)
  }

  const filterOutEmptyValues = (val: { [key: string]: any }) => {
    const newVal: { [key: string]: any } = {}
    for (const key in val) {
      if (val[key] !== null && val[key] !== undefined) {
        if (typeof val[key] === "object") {
          if (!Object.keys(val[key]).length) {
            delete newVal[key]
          } else {
            newVal[key] = filterOutEmptyValues(val[key])
            if (!Object.keys(newVal[key]).length) {
              delete newVal[key]
            }
          }
        } else {
          if (val[key] !== "") {
            newVal[key] = val[key]
          } else {
            delete newVal[key]
          }
        }
      } else {
        delete newVal[key]
      }
    }
    return newVal
  }

  const normaliseOptions = (options: any) => {
    return Array.isArray(options)
      ? options.map((el) => ({
          value: el?.value || el,
          label: el?.label || el,
        }))
      : Object.entries(options).map(([value, label]) => ({ value, label }))
  }

  const responsivePlaceholder = (
    values: any,
    key: string | number,
    bp: string
  ) => {
    // check if value has the key on this breakpoint
    if (!values[key] || (values[key][bp] !== undefined && values[key][bp]))
      return ""

    let placeholder = ""
    const currentBPIndex = breakpoints.indexOf(bp)

    breakpoints.forEach((bp, i) => {
      if (i > currentBPIndex) return
      if (values[key][bp] !== undefined) {
        return (placeholder = values[key][bp])
      }
    })

    return placeholder.toString()
  }

  return {
    update,
    updateMeta,
    normaliseOptions,
    filterOutEmptyValues,
    responsivePlaceholder,
  }
}
