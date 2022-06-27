type FieldTypeInterface = {
  update(value: any): void
  updateMeta(value: any): void
  normaliseOptions(options: any): { value: string; label: string }[]
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
    type: Object,
    default: () => ({}),
  },
}

export const useFieldType = (emit: any): FieldTypeInterface => {
  const update = (value: any) => {
    emit("update:modelValue", value)
  }

  const updateMeta = (value: any) => {
    emit("updateMeta", value)
  }

  const normaliseOptions = (options: any) => {
    return Array.isArray(options)
      ? options.map((el) => ({ value: el, label: el }))
      : Object.entries(options).map(([value, label]) => ({ value, label }))
  }

  return {
    update,
    updateMeta,
    normaliseOptions,
  }
}
